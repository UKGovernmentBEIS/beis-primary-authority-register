<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\par_forms\ParFormBuilder;
use Drupal\par_forms\ParFormPluginBase;

/**
 * About business form plugin.
 *
 * @ParForm(
 *   id = "select_enforced_legal_entity",
 *   title = @Translation("Legal entity selection for enforcement form.")
 * )
 */
class ParSelectEnforcedLegalEntityForm extends ParFormPluginBase {

  const ADD_NEW = 'add_new';

  /**
   * {@inheritdoc}
   */
  public function loadData($cardinality = 1) {
    $par_data_partnership = $this->getFlowDataHandler()->getParameter('par_data_partnership');
    $par_data_organisation = $this->getFlowDataHandler()->getParameter('par_data_organisation');

    $select_legal_entities = [];

    // Get all the legal entities for the given organisation.
    if ($par_data_partnership && $par_data_organisation) {
      // We must only show the intersection of legal entities between the partnership and the organisation.
      $organisation_legal_entities = $this->getParDataManager()->getEntitiesAsOptions($par_data_organisation->getLegalEntity());
      $partnership_legal_entities = $this->getParDataManager()->getEntitiesAsOptions($par_data_partnership->getLegalEntity());

      $select_legal_entities = array_intersect_key($partnership_legal_entities, $organisation_legal_entities);
    }

    $this->getFlowDataHandler()->setFormPermValue('select_legal_entities', $select_legal_entities);

    parent::loadData();
  }

  /**
   * {@inheritdoc}
   */
  public function getElements($form = [], $cardinality = 1) {
    // Get all the allowed authorities.
    $select_legal_entities = $this->getFlowDataHandler()->getFormPermValue('select_legal_entities');

    $form['alternative_legal_entity'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the name of the legal entity'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("alternative_legal_entity"),
      '#weight' => 101,
    ];

    // If the partnership is direct or there is only one member go to the next step.
    if (count($select_legal_entities) >= 1) {
      // Add the ability to add a non-associated legal entity name.
      $select_legal_entities[self::ADD_NEW] = 'Add a legal entity';

      $form['legal_entities_select'] = [
        '#type' => 'radios',
        '#title' => $this->t('Select a legal entity'),
        '#options' => $select_legal_entities,
        '#default_value' => $this->getFlowDataHandler()->getDefaultValues('legal_entities_select', key($select_legal_entities)),
        '#weight' => 100,
        '#required' => TRUE,
        '#prefix' => '<div>',
        '#suffix' => '</div>',
      ];

      // Make sure the alternative legal entity field is selectively available.
      $form['alternative_legal_entity']['#states'] = [
        'visible' => [
          ':input[name="' . $this->getTargetName($this->getElementKey('legal_entities_select', $cardinality)) . '"]' => ['value' => 'add_new'],
        ],
      ];
    }
    else {
      $form['legal_entities_select'] = [
        '#type' => 'hidden',
        '#value' => self::ADD_NEW,
      ];
    }

    return $form;
  }

  /**
   * Validate date field.
   */
  public function validate($form, &$form_state, $cardinality = 1, $action = ParFormBuilder::PAR_ERROR_DISPLAY) {
    $legal_entity = $this->getElementKey('legal_entities_select');
    $alternative_legal_entity = $this->getElementKey('alternative_legal_entity');
    if ((empty($form_state->getValue($legal_entity)) || $form_state->getValue($legal_entity) === self::ADD_NEW)
      && empty($form_state->getValue($alternative_legal_entity))) {

      $id_key = $this->getElementKey('alternative_legal_entity', $cardinality, TRUE);
      $form_state->setErrorByName($this->getElementName($alternative_legal_entity), $this->wrapErrorMessage('You must choose a legal entity.', $this->getElementId($id_key, $form)));
    }

    return parent::validate($form, $form_state, $cardinality, $action);
  }
}
