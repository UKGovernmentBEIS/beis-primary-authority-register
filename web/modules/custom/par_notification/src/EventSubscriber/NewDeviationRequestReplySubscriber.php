<?php

namespace Drupal\par_notification\EventSubscriber;

use Drupal\comment\CommentInterface;
use Drupal\Core\Entity\EntityEvent;
use Drupal\Core\Entity\EntityEvents;
use Drupal\message\Entity\Message;
use Drupal\par_data\Entity\ParDataDeviationRequest;
use Drupal\par_data\Entity\ParDataEntityInterface;
use Drupal\par_data\Entity\ParDataGeneralEnquiry;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_notification\ParNotificationException;
use Drupal\par_notification\ParNotificationSubscriberBase;

class NewDeviationRequestReplySubscriber extends ParNotificationSubscriberBase {

  /**
   * The message template ID created for this notification.
   *
   * @see /admin/structure/message/manage/new_deviation_response
   */
  const MESSAGE_ID = 'new_deviation_response';

  /**
   * The events to react to.
   *
   * @return mixed
   */
  static function getSubscribedEvents() {
    $events[EntityEvents::insert('comment')][] = ['onEvent', 800];

    return $events;
  }

  /**
   * Get all the recipients for this notification.
   *
   * @param $event
   *
   * @return ParDataPerson[]
   */
  public function getRecipients(EntityEvent $event) {
    $contacts = [];

    /** @var CommentInterface $comment */
    $comment = $event->getEntity();
    /** @var ParDataEntityInterface $entity */
    $entity = $comment->getCommentedEntity();

    // Always notify the primary authority contact.
    if ($primary_authority_contacts = $entity->getPrimaryAuthorityContacts()) {
      foreach ($primary_authority_contacts as $contact) {
        if (!isset($contacts[$contact->id()])) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }
    // Always notify the enforcing officer.
    if ($enforcing_authority_contact = $entity->getEnforcingPerson(TRUE)) {
      $contacts[$enforcing_authority_contact->id()] = $enforcing_authority_contact;
    }

    // Notify secondary contacts if they've opted-in.
    $secondary_primary_authority_contacts = $entity->getAllPrimaryAuthorityContacts();
    $secondary_enforcing_authority_contacts = $entity->getEnforcingAuthorityContacts();
    if ($secondary_contacts = $entity->combineContacts($secondary_primary_authority_contacts, $secondary_enforcing_authority_contacts)) {
      foreach ($secondary_contacts as $contact) {
        if (!isset($contacts[$contact->id()]) && $contact->hasNotificationPreference(self::MESSAGE_ID)) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }

    // Remove the contact if they are they created this response.
    for ($i = 0; $i > count($contacts); $i++) {
      $contact = &$contacts[$i];
      $account = $contact->lookupUserAccount();
      if ($account && $account->id() !== $comment->getOwnerId()) {

        unset($contact);
      }
    }

    return array_filter($contacts);
  }

  /**
   * @param EntityEvent $event
   */
  public function onEvent(EntityEvent $event) {
    /** @var CommentInterface $comment */
    $comment = $event->getEntity();
    /** @var ParDataEntityInterface $entity */
    $par_data_entity = $comment->getCommentedEntity();
    $par_data_partnership = $par_data_entity ? $par_data_entity->getPartnership(TRUE) : NULL;

    // If the commented entity is not a deviation request do not process this event.
    if (!$par_data_entity instanceof ParDataDeviationRequest) {
      return;
    }

    $contacts = $this->getRecipients($event);
    foreach ($contacts as $contact) {
      if (!isset($this->recipients[$contact->getEmail()])) {
        // Record the recipient so that we don't send them the message twice.
        $this->recipients[$contact->getEmail] = $contact;
        // Try and get the user account associated with this contact.
        $account = $contact->getUserAccount();

        try {
          /** @var Message $message */
          $message = $this->createMessage();
        }
        catch (ParNotificationException $e) {
          break;
        }

        // Add contextual information to this message.
        if ($message->hasField('field_comment')) {
          $message->set('field_comment', $comment);
        }
        if ($message->hasField('field_deviation_request')) {
          $message->set('field_deviation_request', $par_data_entity);
        }

        // Add some custom arguments to this message.
        $message->setArguments([
          '@first_name' => $contact->getFirstName(),
          '@partnership_label' => $par_data_partnership ? strtolower($par_data_partnership->label()) : 'partnership',
        ]);

        // The owner is the user who this message belongs to.
        if ($account) {
          $message->setOwnerId($account->id());
        }

        // Send the message.
        $this->sendMessage($message, $contact->getEmail());
      }
    }
  }

}
