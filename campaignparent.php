<?php

require_once 'campaignparent.civix.php';

/**
 * Implementation of hook_civicrm_buildForm
 * 
 * - add campaign type parent to form
 * 
 * @author Erik Hommel (erik.hommel@civicoop.org)
 * @date 7 Jan 2014
 * @param string $formName (name of the form)
 *        object $form
 */
function campaignparent_civicrm_buildForm($formName, &$form) {
    if ($formName == "CRM_Admin_Form_RelationshipType") {
        CRM_Core_Error::debug("form", $form);
        exit();
    }
    if ($formName == "CRM_Admin_Form_Options") {
        /*
         * add campaign type parent to the form if we are dealing with
         * campaign types
         */
        $option_group = $form->getVar('_gName');
        if ($option_group == "campaign_type") {
            /*
             * add parent type to form
             */
            
            $campaign_types = CRM_Campaign_PseudoConstant::campaignType();
            $parent_types = array_merge(array("- none"), $campaign_types);
            $form->addElement('select', 'parent_types', ts('Parent Type'), $parent_types);
            /*
             * if add, set default to - none, else show current value
             */
            

          //CRM_Core_Error::debug("form", $form);
        //exit();
          
            $template_path = realpath(dirname(__FILE__)."/templates");
            $form->add('text', 'CampaignParent', ts('CampaignParent'));
            CRM_Core_Region::instance('page-body')->add(array(
                'template' => "{$template_path}/CampaignParent.tpl"));
            //CRM_Core_Error::debug("form", $form);
            //exit();
        }
    }
}





/**
 * Implementation of hook_civicrm_config
 */
function campaignparent_civicrm_config(&$config) {
  _campaignparent_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function campaignparent_civicrm_xmlMenu(&$files) {
  _campaignparent_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function campaignparent_civicrm_install() {
  return _campaignparent_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function campaignparent_civicrm_uninstall() {
  return _campaignparent_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function campaignparent_civicrm_enable() {
  return _campaignparent_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function campaignparent_civicrm_disable() {
  return _campaignparent_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function campaignparent_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _campaignparent_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function campaignparent_civicrm_managed(&$entities) {
  return _campaignparent_civix_civicrm_managed($entities);
}
