<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\par_forms\ParFormPluginBase;

/**
 * About business form plugin.
 *
 * @ParForm(
 *   id = "business_size",
 *   title = @Translation("Number of members form.")
 * )
 */
class ParBusinessSizeForm extends ParFormPluginBase {

  /**
   * Mapping of the data parameters to the form elements.
   */
  protected $formItems = [
    'par_data_organisation:organisation' => [
      'business_size' => 'employees_band',
    ],
  ];

  /**
   * {@inheritdoc}
   */
  public function getElements($form = []) {
    $organisation_bundle = $this->getParDataManager()->getParBundleEntity('par_data_organisation');

    $form['info'] = [
      '#markup' => t('Enter the number of associations in your membership list'),
      '#prefix' => '<h2>',
      '#suffix' => '</h2>',
    ];

    // Business details.
    $form['business_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of members'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues('business_size'),
      '#options' => $organisation_bundle->getAllowedValues('size'),
    ];

    return $form;
  }
}
