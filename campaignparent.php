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
    if ($formName == "CRM_Admin_Form_Options") {
        /*
         * add campaign type parent to the form if we are dealing with
         * campaign types
         */
        $option_group = $form->getVar('_gName');
        $form_action = $form->getVar('_action');
        if ($option_group == "campaign_type") {
            /*
             * add parent type to form
             */
            $campaign_types = CRM_Campaign_PseudoConstant::campaignType();
            $campaign_types[0] = "- none";
            asort($campaign_types);
            $form->addElement('select', 'parent_types', ts('Parent Type'), $campaign_types);
            /*
             * if add, set default to - none, else show current value
             */
            require_once 'CRM/Campaignparent/CampaignParent.php';
            if ($form_action == 1) {
                $defaults = array('parent_types' => 0);
                $form->setDefaults($defaults);                
            } else {
                /*
                 * retrieve parent with campaign_type_id
                 */
                $form_values = $form->getVar('_values');
                $campaign_type_id = $form_values['value'];
                $query = "SELECT parent_campaign_type_id FROM civicrm_campaign_type_parent 
                    WHERE campaign_type_id = $campaign_type_id";
                $dao = CRM_Core_DAO::executeQuery($query);
                if ($dao->fetch()) {
                    /*
                     * retrieve label so we can set the correct 
                     */
                    $defaults = array('parent_types' => $dao->parent_campaign_type_id);
                    $form->setDefaults($defaults);
                }
            }            
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
/**
 * Implementation of hook_civicrm_postProcess
 * 
 * For campaign_types : update parent table
 */
function campaignparent_civicrm_postProcess( $formName, &$form ) {
    /*
     * pick up after form CRM_Admin_Form_Options
     * if dealing with campaign_types
     */
    if ($formName ==  "CRM_Admin_Form_Options") {
        $gname = $form->getVar('_gName');
        if ($gname == "campaign_type") {
            $action = $form->getVar('_action');
            $option_value_id = $form->getVar('_id');
            $submit_values = $form->getVar('_submitValues');
            /*
             * if parent_types is not empty, update or insert 
             * campaign parent type 
             */
            if (!empty($submit_values['parent_types'])) {
                $query = "SELECT value FROM civicrm_option_value WHERE id = $option_value_id";
                $dao = CRM_Core_DAO::executeQuery($query);
                if ($dao->fetch()) {
                    $params = array(
                        'campaign_type_id'          =>  $dao->value,
                        'parent_campaign_type_id'   =>  $submit_values['parent_types']
                    );
                    $existing = CRM_Campaignparent_CampaignParent::getCampaignTypeParent($dao->value);
                    if (empty($existing)) {
                        CRM_Campaignparent_CampaignParent::createCampaignParentType($params);
                    } else {
                        CRM_Campaignparent_CampaignParent::updateCampaignParentType($params);
                    }
                }
            }
        }
    }
}
