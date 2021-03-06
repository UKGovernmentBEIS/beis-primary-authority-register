<?php

namespace Drupal\par_subscriptions\EventSubscriber;

use Drupal\Core\Entity\EntityEvent;
use Drupal\Core\Entity\EntityEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserDefaultSubscriber implements EventSubscriberInterface {

  /**
   * The events to react to.
   *
   * @return mixed
   */
  static function getSubscribedEvents() {
    $events[EntityEvents::insert('user')][] = ['onEvent', 10];
    return $events;
  }

  public function getSubscriptionManager() {
    return \Drupal::service('par_subscriptions.manager');
  }

  /**
   * @param EntityEvent $event
   */
  public function onEvent(EntityEvent $event) {
    /** @var \Drupal\user\Entity\User $user */
    $user = $event->getEntity();

    $lists = $this->getSubscriptionManager()->getLists();

    foreach ($lists as $list) {
      $subscription = $user->id() > 1 ?
        $this->getSubscriptionManager()->createSubscription($list, $user->getEmail()) :
        NULL;

      // Silently subscribe & verify the user.
      if ($subscription instanceof \Drupal\par_subscriptions\Entity\ParSubscriptionInterface) {
        $subscription->verify();
      }
    }
  }
}
