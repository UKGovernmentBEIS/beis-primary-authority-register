<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\comment\CommentInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Link;
use Drupal\par_data\Entity\ParDataEntityInterface;
use Drupal\par_flows\ParFlowException;
use Drupal\par_forms\ParEntityMapping;
use Drupal\par_forms\ParFormPluginBase;

/**
 * Partnership contact display.
 *
 * @ParForm(
 *   id = "partnership_contacts",
 *   title = @Translation("Partnership contact display.")
 * )
 */
class ParPartnershipContacts extends ParFormPluginBase {

  /**
   * {@inheritdoc}
   */
  public function loadData($cardinality = 1) {
    $par_data_partnership = $this->getFlowDataHandler()->getParameter('par_data_partnership');

    if ($authority_contacts = $par_data_partnership->getAuthorityPeople()) {
      $this->setDefaultValuesByKey("authority_people", $cardinality, $authority_contacts);
    }
    if ($organisation_contacts = $par_data_partnership->getOrganisationPeople()) {
      $this->setDefaultValuesByKey("organisation_people", $cardinality, $organisation_contacts);
    }

    // Set configuration options.
    $show_title = isset($this->getConfiguration()['show_title']) ? (bool) $this->getConfiguration()['show_title'] : TRUE;
    $this->getFlowDataHandler()->setFormPermValue("show_title", $show_title);

    $show_authority_contacts = isset($this->getConfiguration()['authority_contacts']) ? (bool) $this->getConfiguration()['authority_contacts'] : TRUE;
    $this->getFlowDataHandler()->setFormPermValue("show_authority_contacts", $show_authority_contacts);

    $show_organisation_contacts = isset($this->getConfiguration()['organisation_contacts']) ? (bool) $this->getConfiguration()['organisation_contacts'] : TRUE;
    $this->getFlowDataHandler()->setFormPermValue("show_organisation_contacts", $show_organisation_contacts);

    parent::loadData();
  }

  /**
   * {@inheritdoc}
   */
  public function getElements($form = [], $cardinality = 1) {
    if ($this->getFlowDataHandler()->getFormPermValue("show_title")) {
      $form['title'] = [
        '#type' => 'html_tag',
        '#tag' => 'h2',
        '#value' => "Contacts",
        '#attributes' => ['class' => 'heading-large'],
      ];
    }
    // Display the legal entities.
    $form['contacts'] = [
      '#type' => 'fieldset',
      '#title' => 'Legal entities',
      '#attributes' => ['class' => ['form-group']],
      'legal_entity' => [
        '#type' => 'container',
        '#attributes' => ['class' => ['grid-row']],
      ],
    ];

    $legal_entities = $this->getDefaultValuesByKey('legal_entities', $cardinality, []);
    foreach ($legal_entities as $delta => $legal_entity) {
      $legal_entity_view_builder = $this->getParDataManager()->getViewBuilder('par_data_legal_entity');
      $legal_entity_summary = $legal_entity_view_builder->view($legal_entity, 'summary');

      $form['legal_entities']['legal_entity'][$delta] = [
        '#type' => 'container',
        '#attributes' => ['class' => 'column-full'],
        'name' => [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#value' => $this->getRenderer()->render($legal_entity_summary),
          '#attributes' => ['class' => 'legal-entity'],
        ],
      ];

      // Generate item operation links.
      $operations = [];
      try {
        // Edit the legal entity.
        $params['par_data_legal_entity'] = $legal_entity->id();
        $options = ['attributes' => ['aria-label' => $this->t("Edit the legal entity @label", ['@label' => strtolower($legal_entity->label())])]];
        $operations['edit'] = $this->getFlowNegotiator()->getFlow()->getLinkByCurrentOperation('edit_field_legal_entity', $params, $options, TRUE);
      }
      catch (ParFlowException $e) {
        $this->getLogger($this->getLoggerChannel())->notice($e);
      }
      try {
        // Remove the legal entity.
        $params['field_legal_entity_delta'] = $delta;
        $options = ['attributes' => ['aria-label' => $this->t("Remove the legal entity @label", ['@label' => strtolower($legal_entity->label())])]];
        $operations['remove'] = $this->getFlowNegotiator()->getFlow()->getLinkByCurrentOperation('remove_field_legal_entity', $params, $options, TRUE);
      }
      catch (ParFlowException $e) {
        $this->getLogger($this->getLoggerChannel())->notice($e);
      }

      // Display operation links if any are present.
      if (!empty(array_filter($operations))) {
        $form['legal_entities']['legal_entity'][$delta]['operations'] = [
          '#type' => 'container',
          '#attributes' => ['class' => ['grid-row']],
        ];
        if (isset($operations['edit']) && $operations['edit'] instanceof Link) {
          $form['legal_entities']['legal_entity'][$delta]['operations']['edit'] = [
            '#type' => 'html_tag',
            '#tag' => 'p',
            '#value' => $operations['edit']->setText("edit legal entity")->toString(),
            '#attributes' => ['class' => ['edit-legal-entity', 'column-one-third']],
          ];
        }
        if (isset($operations['remove']) && $operations['remove'] instanceof Link) {
          $form['legal_entities']['legal_entity'][$delta]['operations']['remove'] = [
            '#type' => 'html_tag',
            '#tag' => 'p',
            '#value' => $operations['remove']->setText("remove legal entity")->toString(),
            '#attributes' => ['class' => ['remove-legal-entity', 'column-one-third']],
          ];
        }
      }
    }

    // Add a link to add a legal entity.
    try {
      $legal_entity_add_link = $this->getFlowNegotiator()->getFlow()->getLinkByCurrentOperation('add_field_legal_entity', [], [], TRUE);
    }
    catch (ParFlowException $e) {
      $this->getLogger($this->getLoggerChannel())->notice($e);
    }

    if (isset($legal_entity_add_link) && $legal_entity_add_link instanceof Link) {
      $link_label = count($legal_entities) > 1 ? "add another legal entity" : "add a legal entity";
      $form['legal_entities']['add'] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $legal_entity_add_link->setText($link_label)->toString(),
        '#attributes' => ['class' => ['add-trading-name']],
      ];
    }

    return $form;
  }

  /**
   * Return no actions for this plugin.
   */
  public function getElementActions($cardinality = 1, $actions = []) {
    return $actions;
  }

  /**
   * Return no actions for this plugin.
   */
  public function getComponentActions($actions = [], $count = NULL) {
    return $actions;
  }
}
