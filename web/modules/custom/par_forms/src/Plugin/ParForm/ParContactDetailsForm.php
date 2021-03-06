<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\par_forms\ParFormBuilder;
use Drupal\par_forms\ParFormPluginBase;

/**
 * Contact details form plugin.
 *
 * @ParForm(
 *   id = "contact_details",
 *   title = @Translation("Contact details form.")
 * )
 */
class ParContactDetailsForm extends ParFormPluginBase {

  /**
   * {@inheritdoc}
   */
  protected $entityMapping = [
    ['first_name', 'par_data_person', 'first_name', NULL, NULL, 0, [
      'You must fill in the missing information.' => 'You must enter the first name for this contact.'
    ]],
    ['last_name', 'par_data_person', 'last_name', NULL, NULL, 0, [
      'You must fill in the missing information.' => 'You must enter the last name for this contact.'
    ]],
    ['work_phone', 'par_data_person', 'work_phone', NULL, NULL, 0, [
      'You must fill in the missing information.' => 'You must enter the work phone number for this contact.'
    ]],
    ['mobile_phone', 'par_data_person', 'mobile_phone', NULL, NULL, 0, [
      'You must fill in the missing information.' => 'You must enter the mobile phone number for this contact.'
    ]],
    ['email', 'par_data_person', 'email', NULL, NULL, 0, [
      'You must fill in the missing information.' => 'You must enter the email address for this contact.'
    ]],
  ];

  /**
   * Load the data for this form.
   */
  public function loadData($cardinality = 1) {
    if ($par_data_person = $this->getFlowDataHandler()->getParameter('par_data_person')) {
      $this->setDefaultValuesByKey("salutation", $cardinality, $par_data_person->get('salutation')->getString());
      $this->setDefaultValuesByKey("first_name", $cardinality, $par_data_person->get('first_name')->getString());
      $this->setDefaultValuesByKey("last_name", $cardinality, $par_data_person->get('last_name')->getString());
      $this->setDefaultValuesByKey("work_phone", $cardinality, $par_data_person->get('work_phone')->getString());
      $this->setDefaultValuesByKey("mobile_phone", $cardinality, $par_data_person->get('mobile_phone')->getString());
      $this->setDefaultValuesByKey("email", $cardinality, $par_data_person->get('email')->getString());

      // Provide an option to limit whether the email address can be entered.
      $limit_all_users = isset($this->getConfiguration()['limit_all_users']) ? (bool) $this->getConfiguration()['limit_all_users'] : FALSE;
      if ($limit_all_users) {
        $this->setDefaultValuesByKey("email_readonly", $cardinality, TRUE);
      }
    }

    parent::loadData();
  }

  /**
   * {@inheritdoc}
   */
  public function getElements($form = [], $cardinality = 1) {
    $form['salutation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the title (optional)'),
      '#description' => $this->t('For example, Ms Mr Mrs Dr'),
      '#default_value' => $this->getDefaultValuesByKey('salutation', $cardinality),
    ];

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the first name'),
      '#default_value' => $this->getDefaultValuesByKey('first_name', $cardinality),
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the last name'),
      '#default_value' => $this->getDefaultValuesByKey('last_name', $cardinality),
    ];

    $form['work_phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Enter the work phone number'),
      '#default_value' => $this->getDefaultValuesByKey('work_phone', $cardinality),
    ];

    $form['mobile_phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Enter the mobile phone number (optional)'),
      '#default_value' => $this->getDefaultValuesByKey('mobile_phone', $cardinality),
    ];

    // Prevent modifying of email address when un-editable.
    if ($this->getDefaultValuesByKey('email_readonly', $cardinality, FALSE)) {
      $form['email_readonly'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Email address'),
        '#description' => $this->t('You cannot update this person\'s email address because they already have an account.'),
        '#attributes' => ['class' => ['form-group']],
        'email_address' => [
          '#type' => 'markup',
          '#markup' => $this->getDefaultValuesByKey('email', $cardinality),
          '#prefix' => '<p>',
          '#suffix' => '</p>',
        ],
      ];
      $form['email'] = [
        '#type' => 'hidden',
        '#value' => $this->getDefaultValuesByKey('email', $cardinality),
      ];
    }
    else {
      $form['email'] = [
        '#type' => 'email',
        '#title' => $this->t('Enter the email address'),
        '#default_value' => $this->getDefaultValuesByKey('email', $cardinality),
      ];
    }

    return $form;
  }
}
