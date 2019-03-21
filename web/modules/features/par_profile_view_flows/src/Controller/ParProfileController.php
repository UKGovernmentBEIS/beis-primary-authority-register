<?php

namespace Drupal\par_profile_view_flows\Controller;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_flows\Controller\ParBaseController;
use Drupal\par_flows\ParFlowException;
use Drupal\par_forms\ParFormBuilder;

/**
 * A controller for displaying the application confirmation.
 */
class ParProfileController extends ParBaseController {

  /**
   * @return DateFormatterInterface
   */
  protected function getDateFormatter() {
    return \Drupal::service('date.formatter');
  }

  /**
   * Title callback default.
   */
  public function titleCallback() {
    $par_data_person = $this->getFlowDataHandler()->getParameter('par_data_person');
    $name = $par_data_person ? $par_data_person->getFullName() : NULL;

    if (!empty($name)) {
      $this->pageTitle = ucfirst($name);
    }
    else {
      $this->pageTitle = 'Profile';
    }

    return parent::titleCallback();
  }

  public function loadData() {
    $par_data_person = $this->getFlowDataHandler()->getParameter('par_data_person');
    $user = $par_data_person ? $par_data_person->getUserAccount() : NULL;

    if ($user) {
      $this->getFlowDataHandler()->setParameter('user', $user);
    }

    if ($user && $people = $this->getParDataManager()->getUserPeople($user)) {
      $this->getFlowDataHandler()->setParameter('contacts', $people);
      $this->getFlowDataHandler()->setTempDataValue(ParFormBuilder::PAR_COMPONENT_PREFIX . 'contact_detail', $people);
    }
    else {
      $this->getFlowDataHandler()->setParameter('contacts', [$par_data_person]);
      $this->getFlowDataHandler()->setTempDataValue(ParFormBuilder::PAR_COMPONENT_PREFIX . 'contact_detail', [$par_data_person]);
    }

    parent::loadData();
  }

  public function build($build = []) {
    if ($par_data_person = $this->getFlowDataHandler()->getParameter('par_data_person')) {
      $this->addCacheableDependency($par_data_person);
    }
    if ($user = $this->getFlowDataHandler()->getParameter('user')) {
      $this->addCacheableDependency($user);
    }
    if ($contacts = $this->getFlowDataHandler()->getParameter('contacts')) {
      foreach ($contacts as $contact) {
        $this->addCacheableDependency($contact);
      }
    }

    return parent::build($build);
  }

}