<?php

namespace Drupal\par_migration\Plugin\migrate\source;

use Drupal\Core\State\StateInterface;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Migration of PAR2 Business Organisation.
 *
 * @MigrateSource(
 *   id = "par_migration_business_organisation"
 * )
 */
class ParBusinessOrganisation extends SqlBase {

  /**
   * @var string $table The name of the database table.
   */
  protected $table = 'par_organisations';

  /**
   * @var array
   *   A cached array of trading names keyed by organisation ID.
   */
  protected $tradingNames = [];

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);

    $this->collectTradingNames();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration = NULL) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select($this->table, 'a')
      ->fields('a', [
        'organisation_id',
        'name',
        'par_role',
        'size_category',
        'employees_band',
        'phone',
        'email',
        'nation',
        'first_name',
        'last_name',
        'premises_on_map_ok',
        'comments',
        'coordinator_number_eligible',
        'coordinator_type',
      ])
      ->condition('par_role', 'Business');
  }

  protected function collectTradingNames() {
    $result = $this->select('par_trading_names', 't')
      ->fields('t', [
        'trading_name_id',
        'organisation_id',
        'name',
      ])
      ->isNotNull('t.organisation_id')
      ->orderBy('t.organisation_id')
      ->execute();

    while ($row = $result->fetchAssoc()) {
      $this->tradingNames[$row['organisation_id']][] = $row['name'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'organisation_id' => $this->t('Organisation ID'),
      'name' => $this->t('Name'),
      'par_role' => $this->t('PAR role'),
      'size_category' => $this->t('Size category'),
      'employees_band' => $this->t('Employees band'),
      'phone' => $this->t('Phone'),
      'email' => $this->t('Email'),
      'nation' => $this->t('Nation'),
      'first_name' => $this->t('First name'),
      'last_name' => $this->t('Last name'),
      'premises_on_map_ok' => $this->t('Premises on map'),
      'comments' => $this->t('Comments'),
      'trading_names' => $this->t('Trading names'),
      'coordinator_number_eligible' => $this->t('Coordinator number eligible'),
      'coordinator_type' => $this->t('Coordinator type'),
    ];
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'person_id' => [
        'type' => 'integer',
      ],
      'organisation_id' => [
        'type' => 'integer',
      ],
    ];
  }

  /**
   * Attaches "nid" property to a row if row "bid" points to a
   *
   * @param \Drupal\migrate\Row $row
   *
   * @return bool
   * @throws \Exception
   */
  function prepareRow(Row $row) {
    return parent::prepareRow($row);

    $organisation = $row->getSourceProperty('organisation_id');
    $trading_names = array_key_exists($organisation, $this->tradingNames) ? $this->tradingNames[$organisation] : [];
    $row->setSourceProperty('trading_names', $trading_names);
  }

}
