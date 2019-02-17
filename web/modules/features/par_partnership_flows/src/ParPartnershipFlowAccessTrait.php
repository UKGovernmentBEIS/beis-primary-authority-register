<?php

namespace Drupal\par_partnership_flows;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\ParFlowException;
use Symfony\Component\Routing\Route;
use Drupal\Core\Routing\RouteMatchInterface;

trait ParPartnershipFlowAccessTrait {

  /**
   * @param \Symfony\Component\Routing\Route $route
   *   The route.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match object to be checked.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account being checked.
   */
  public function accessCallback(Route $route, RouteMatchInterface $route_match, AccountInterface $account, ParDataPartnership $par_data_partnership = NULL) {
    try {
      $this->getFlowNegotiator()->setRoute($route_match);
      $this->getFlowDataHandler()->reset();
      $this->getFlowDataHandler()->setParameter('par_data_partnership', $par_data_partnership);
      $this->loadData();
    } catch (ParFlowException $e) {

    }

    // Get the parameters for this route.

    // If the partnership isn't a coordinated one then don't allow update.
    if (!$par_data_partnership->inProgress()) {
      $this->accessResult = AccessResult::forbidden('This partnership is active therefore the legal entity cannot be updated/added.');
    }

    return parent::accessCallback($route, $route_match, $account);
  }
}
