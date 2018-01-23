<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\par_forms\ParFormPluginBase;

/**
 * Approve an enforcement notice.
 *
 * @ParForm(
 *   id = "contact_details_full",
 *   title = @Translation("Auto-approval of enforcement notices.")
 * )
 */
class ParContactDetailsForm extends ParFormPluginBase {

  protected $formItems = [
    'par_data_person:person' => [
      'first_name' => 'first_name',
      'last_name' => 'last_name',
      'work_phone' => 'work_phone',
      'mobile_phone' => 'mobile_phone',
      'email' => 'email',
      'communication_notes' => 'notes',
    ],
  ];

  public function getElements($form = []) {
    $form['salutation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the title (optional)'),
      '#description' => $this->t('For example, Ms Mr Mrs Dr'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("salutation"),
    ];

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the first name'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("first_name"),
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the last name'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("last_name"),
    ];

    $form['work_phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the work phone number'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("work_phone"),
    ];

    $form['mobile_phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the mobile phone number (optional)'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("mobile_phone"),
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Enter the email address'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("email"),
      // Prevent modifying email if editing an existing user.
      '#disabled' => !empty($par_data_person),
    ];

    // Get preferred contact methods labels.
    $person_bundle = $this->getParDataManager()->getParBundleEntity('par_data_person');
    $contact_options = [
      'communication_email' => $person_bundle->getBooleanFieldLabel('communication_email', 'on'),
      'communication_phone' => $person_bundle->getBooleanFieldLabel('communication_phone', 'on'),
      'communication_mobile' => $person_bundle->getBooleanFieldLabel('communication_mobile', 'on'),
    ];

    $form['preferred_contact'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select the preferred methods of contact (optional)'),
      '#options' => $contact_options,
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("preferred_contact", []),
      '#return_value' => 'on',
    ];

    $form['notes'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Provide contact notes (optional)'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues('notes'),
      '#description' => 'Add any additional notes about how best to contact this person.',
    ];

    return $form;
  }

  public function validate(&$form_state) {
    // @todo create wrapper for setErrorByName as this is ugly creating a link.
    if (empty($form_state->getValue('email'))) {
      $form_state->setErrorByName('email', $this->t('<a href="#edit-email">The email field is required.</a>'));
    }

    if (empty($form_state->getValue('first_name'))) {
      $form_state->setErrorByName('first_name', $this->t('<a href="#edit-first-name">The first name field is required.</a>'));
    }

    if (empty($form_state->getValue('last_name'))) {
      $form_state->setErrorByName('last_name', $this->t('<a href="#edit-last-name">The last name field is required.</a>'));
    }

    if (empty($form_state->getValue('work_phone'))) {
      $form_state->setErrorByName('work_phone', $this->t('<a href="#edit-work-phone">The work phone field is required.</a>'));
    }

    parent::validate($form_state);
  }
}
