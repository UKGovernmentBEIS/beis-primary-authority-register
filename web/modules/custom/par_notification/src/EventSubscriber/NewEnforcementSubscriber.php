<?php

namespace Drupal\par_notification\EventSubscriber;

use Drupal\Core\Entity\EntityEvent;
use Drupal\Core\Entity\EntityEvents;
use Drupal\message\Entity\Message;
use Drupal\par_data\Entity\ParDataEntityInterface;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_notification\ParNotificationException;
use Drupal\par_notification\ParNotificationSubscriberBase;

class NewEnforcementSubscriber extends ParNotificationSubscriberBase {

  /**
   * The message template ID created for this notification.
   *
   * @see /admin/structure/message/manage/new_enforcement_notification
   */
  const MESSAGE_ID = 'new_enforcement_notification';

  /**
   * The events to react to.
   *
   * @return mixed
   */
  static function getSubscribedEvents() {
    $events[EntityEvents::insert('par_data_enforcement_notice')][] = ['onEvent', 800];

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

    /** @var ParDataEntityInterface $entity */
    $entity = $event->getEntity();

    // Always notify the primary authority contacts.
    if ($primary_authority_contacts = $entity->getPrimaryAuthorityContacts()) {
      foreach ($primary_authority_contacts as $contact) {
        if (!isset($contacts[$contact->id()])) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }

    // Notify secondary contacts if they've opted-in.
    if ($secondary_contacts = $entity->getAllPrimaryAuthorityContacts()) {
      foreach ($secondary_contacts as $contact) {
        if (!isset($contacts[$contact->id()]) && $contact->hasNotificationPreference(self::MESSAGE_ID)) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }

    return $contacts;
  }

  /**
   * @param EntityEvent $event
   */
  public function onEvent(EntityEvent $event) {
    /** @var ParDataEntityInterface $par_data_enforcement_notice */
    $par_data_enforcement_notice = $event->getEntity();

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
        if ($message->hasField('field_enforcement_notice')) {
          $message->set('field_enforcement_notice', $par_data_enforcement_notice);
        }

        // Add some custom arguments to this message.
        $message->setArguments([
          '@first_name' => $contact->getFirstName(),
          '@enforced_organisation' => $par_data_enforcement_notice->getEnforcedEntityName(),
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
