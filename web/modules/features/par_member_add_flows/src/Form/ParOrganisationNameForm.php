<?php

namespace Drupal\par_member_add_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;

/**
 * Enter the member organisation name.
 */
class ParOrganisationNameForm extends ParBaseForm {

  protected $formItems = [
    'par_data_organisation:organisation' => [
      'organisation_name' => 'organisation_name',
    ],
  ];

  protected $pageTitle = 'Add member organisation name';

}
