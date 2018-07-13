<?php

require_once 'uimods.civix.php';
use CRM_Uimods_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function uimods_civicrm_config(&$config) {
  _uimods_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function uimods_civicrm_xmlMenu(&$files) {
  _uimods_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function uimods_civicrm_install() {
  _uimods_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function uimods_civicrm_postInstall() {
  _uimods_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function uimods_civicrm_uninstall() {
  _uimods_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function uimods_civicrm_enable() {
  _uimods_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function uimods_civicrm_disable() {
  _uimods_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function uimods_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _uimods_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function uimods_civicrm_managed(&$entities) {
  _uimods_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function uimods_civicrm_caseTypes(&$caseTypes) {
  _uimods_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function uimods_civicrm_angularModules(&$angularModules) {
  _uimods_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function uimods_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _uimods_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Hook implementation: Inject JS code adjusting summary view
 */
function uimods_civicrm_pageRun(&$page) {
  CRM_Core_Region::instance('page-header')->add(array(
    'type' => 'styleUrl',
    'styleUrl' => E::url('css/uimods.css'),
  ));
//  $page_name = $page->getVar('_name');
//  switch ($page_name) {
//    case 'CRM_Contact_Page_View_Summary':
//      CRM_Uimods_OrganisationName::pageRunHook($page);
//      CRM_Uimods_MinorChanges::pageRunHook($page);
//      break;
//    case 'Civi\\Angular\\Page\\Main':
//      CRM_Uimods_MinorChanges::editTokens();
//      break;
//  }
}

/**
 * Implements hook_civicrm_summary().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_summary
 */
function uimods_civicrm_summary($contactID, &$content, &$contentPlacement = CRM_Utils_Hook::SUMMARY_BELOW) {
  $result = civicrm_api3('Relationship', 'get', array(
    'return' => array(
      'end_date',
      'contact_id_b',
    ),
    'contact_id_a' => $contactID,
    'relationship_type_id' => 10,
  ));
  if (!empty($result['values'])) {
    $content = '<div class="crm-summary-block crm-clear">';
    foreach ($result['values'] as $relationship) {
      $assignee = civicrm_api3('Contact', 'getsingle', array(
        'id' => $relationship['contact_id_b'],
        'return' => array('display_name'),
      ));
      $content .= '<div class="crm-summary-row">';
      $content .= '<div class="crm-label">Betreut von:</div><div class="crm-content"><a href="/civicrm/contact/view?reset=1&cid=' . $assignee['id'] . '">' . $assignee['display_name'] . '</a></div>';
      $content .= '<div class="crm-label">Ende:</div><div class="crm-content">' . $relationship ['end_date'] . '</div>';
      $content .= '</div>';
    }
    $content .= '</div>';
    $contentPlacement = CRM_Utils_Hook::SUMMARY_ABOVE;
  }

  $content .= '<div class="crm-summary-block crm-clear">';
  $content .= '<h3>Aktuelle Beziehungen</h3>';
  $vars = array(
    'context' => 'current',
    'contactId' => $contactID,
  );
  $content .= CRM_Core_Smarty::singleton()->fetchWith('CRM/Contact/Page/View/RelationshipSelector.tpl', $vars);
  $content .= '</div>';
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function uimods_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function uimods_civicrm_navigationMenu(&$menu) {
  _uimods_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _uimods_civix_navigationMenu($menu);
} // */
