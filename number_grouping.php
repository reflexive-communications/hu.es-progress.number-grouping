<?php

require_once 'number_grouping.civix.php';

use CRM_NumberGrouping_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function number_grouping_civicrm_config(&$config) {
  _number_grouping_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function number_grouping_civicrm_xmlMenu(&$files) {
  _number_grouping_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function number_grouping_civicrm_install() {
  _number_grouping_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function number_grouping_civicrm_postInstall() {
  _number_grouping_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function number_grouping_civicrm_uninstall() {
  _number_grouping_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function number_grouping_civicrm_enable() {
  _number_grouping_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function number_grouping_civicrm_disable() {
  _number_grouping_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function number_grouping_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _number_grouping_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function number_grouping_civicrm_managed(&$entities) {
  _number_grouping_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 *
 * @throws \CRM_Core_Exception
 */
function number_grouping_civicrm_caseTypes(&$caseTypes) {
  _number_grouping_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function number_grouping_civicrm_angularModules(&$angularModules) {
  _number_grouping_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function number_grouping_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _number_grouping_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function number_grouping_civicrm_entityTypes(&$entityTypes) {
  _number_grouping_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function number_grouping_civicrm_themes(&$themes) {
  _number_grouping_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_tokenValues
 *
 * Formats custom token numbers to group by thousands
 *
 * @param $values
 * @param $cids
 * @param null $job
 * @param array $tokens
 * @param null $context
 *
 * @throws \Civi\API\Exception\UnauthorizedException
 */
function number_grouping_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = [], $context = NULL) {

  // Apply only for contact tokens
  if (!isset($tokens['contact'])) {
    return;
  }

  // Get settings
  $result = \Civi\Api4\Setting::get()
    ->setSelect([
      'monetaryThousandSeparator',
      'monetaryDecimalPoint',
    ])
    ->execute();

  foreach ($result as $row) {
    $settings[$row['name']] = $row['value'];
  }

  foreach ($tokens['contact'] as $tokenName => $tokenValue) {

    // Only for custom tokens
    if (substr($tokenName, 0, 6) != 'custom') {
      continue;
    }

    foreach ($cids as $cid) {

      $value = $values[$cid][$tokenName];

      // Is it numeric?
      if (is_numeric($value)) {
        $values[$cid][$tokenName] = number_format($value, 0, $settings['monetaryDecimalPoint'],$settings['monetaryThousandSeparator'] );
      }
    }
  }
}
