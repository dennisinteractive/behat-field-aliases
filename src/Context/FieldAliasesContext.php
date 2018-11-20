<?php

namespace DennisDigital\Behat\FieldAliases\Context;

use Behat\Testwork\Hook\HookDispatcher;
use Drupal\DrupalDriverManager;
use Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Context\DrupalAwareInterface;
use Drupal\DrupalUserManagerInterface;
use DennisDigital\Behat\FieldAliases\Context\FieldAliasesClass\FieldAliases;

/**
 * Class FieldAliasesContext
 * @package DennisDigital\Behat\FieldAliases\Context
 */
class FieldAliasesContext implements DrupalAwareInterface {

  /**
   * Drupal context.
   */
  protected $drupalContext;

  /**
   * @var DrupalDriverManager
   */
  private $drupal;

  /**
   * Stores the field mapping.
   */
  protected $fieldMapping;

  /**
   * @inheritdoc
   */
  public function __construct($fieldMapping = array())
  {
    $this->fieldMapping = reset($fieldMapping);
  }

  /**
   * @inheritDoc
   */
  public function setDrupal(DrupalDriverManager $drupal) {
    $this->drupal = $drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDispatcher(HookDispatcher $dispatcher) {
  }

  /**
   * @inheritDoc
   */
  public function getDrupal() {
    return $this->drupal;
  }

  /**
   * @inheritDoc
   */
  public function setDrupalParameters(array $parameters) {
  }

  /**
   * @inheritdoc
   */
  public function setUserManager(DrupalUserManagerInterface $userManager) {
  }

  /**
   * @inheritdoc
   */
  public function getUserManager() {
  }

  /**
   * Stores the field aliases.
   */
  protected $fieldAliases;

  /**
   * Transforms fields with human readable names into their respective
   * machine names.
   * We loop all the values and find matches against the mapping table.
   * Ideally we should be able to replace only the first line of the table, that
   * contains the field names. The problem is that we don't have a way to detect
   * if the table is vertical or horizontal. This could lead to actual values
   * being changed if they match a field name from the mapping.
   *
   * @Transform table:*
   */
  public function humanFieldNames(TableNode $table) {
    $fieldAliases = New FieldAliases($this->fieldMapping);
    $aliases = $fieldAliases->getAliases();
    $table = $table->getTable();

    if (sizeof($table) > 2) {
      // Its a vertical table, convert to horizontal.
      $tmp = array();
      foreach ($table as $row => $item) {
        $tmp[0][] = $item[0];
        $tmp[1][] = $item[1];
      }
      $table = $tmp;
    }

    foreach ($table as $rowkey => $row) {
      foreach ($row as $colkey => $value) {
        $value = $table[$rowkey][$colkey];
        if (isset($aliases[$value])) {
          $table[$rowkey][$colkey] = $aliases[$value];
        }
      }
    }
    //var_dump($table);ob_flush();

    return new TableNode($table);
  }
}
