<?php

/**
 * Collection of upgrade steps
 */
class CRM_Campaignparent_Upgrader extends CRM_Campaignparent_Upgrader_Base {
    
    /**
     * implementation of function install()
     * 
     * create MySQL files when they do not exist yet:
     * - civicrm_case_parent
     * - civicrm_campaign_parent
     * - civicrm_campaign_type_parent
     * - civicrm_case_type_parent
     * 
     * @author Erik Hommel (erik.hommel@civicoop.org)
     * @date 7 Jan 2014
     * 
     */
    public function install() {
        if (!CRM_Core_DAO::checkTableExists('civicrm_case_type_parent')) {
            $this->executeSqlFile('sql/createCaseTypeParent.sql');
        }
        
        if (!CRM_Core_DAO::checkTableExists('civicrm_campaign_type_parent')) {
            $this->executeSqlFile('sql/createCampaignTypeParent.sql');
        }
        
        if (!CRM_Core_DAO::checkTableExists('civicrm_case_parent')) {
            $this->executeSqlFile('sql/createCaseParent.sql');
        }
        
        if (!CRM_Core_DAO::checkTableExists('civicrm_campaign_parent')) {
            $this->executeSqlFile('sql/createCampaignParent.sql');
        }
    }
}
