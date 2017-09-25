<?php

namespace Drupal\par_data\Views;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for trance entities.
 */
class ParDataViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $entity_type_label = $this->entityType->getLabel();

    if (isset($data[$this->entityType->getDataTable()]['table']['base']['title'])) {
      $data[$this->entityType->getDataTable()]['table']['base']['title'] = $entity_type_label;
    }
    if (isset($data[$this->entityType->getRevisionDataTable()]['table']['base']['title'])) {
      $data[$this->entityType->getRevisionDataTable()]['table']['base']['title'] = $this->t('@label revision', [
        '@label' => $entity_type_label,
      ]);
    }

    // Document Completion as a %.
    $data['par_partnerships_revision']['document_completion'] = array(
      'title' => t('Documents Completion Percentage'),
      'field' => [
        'title' => t('Documents Completion Percentage'),
        'help' => t('Completion percentage for partnership required documents'),
        'id' => 'par_partnership_revision_documents_completion_percentage',
      ],
    );

    // Combined Status Field.
    $data['par_partnerships_field_data']['par_combined_status_field'] = array(
      'title' => t('Combined Status Field'),
      'field' => [
        'title' => t('Combined Status Field'),
        'help' => t('Provides a status field that combines several field statuses.'),
        'id' => 'par_partnerships_combined_status_field',
      ],
    );

    // Add the current company computed field to Views.
    $data['par_partnerships_field_data']['par_data_states'] = [
      'title' => t('PAR Status (including states)'),
      'field' => [
        'title' => t('PAR Status (including states)'),
        'help' => t('Provides the status field for PAR entities.'),
        'id' => 'par_data_status',
      ],
    ];

    // Custom filter for Par Membership checks.
    $data['par_partnerships_field_data']['id_filter'] = [
      'title' => t('Partnership: Can user update?'),
      'filter' => [
        'title' => t('Partnership: Can user update?'),
        'help' => t('Filter by partnerships this user can update.'),
        'id' => 'par_member',
      ],
    ];

    return $data;
  }

}
