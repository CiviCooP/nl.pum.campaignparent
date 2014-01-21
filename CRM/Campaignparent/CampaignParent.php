<?php

/**
 * Class CampaignParent for dealing with campaing parent types
 * 
 * @client PUM (http://www.pum.nl)
 * @author Erik Hommel (erik.hommel@civicoop.org, http://www.civicoop.org)
 * @date 14 Jan 2014
 * 
 * Copyright (C) 2014 Coöperatieve CiviCooP U.A.
 * Licensed to PUM and CiviCRM under the Academic Free License version 3.0.
 */
class CRM_Campaignparent_CampaignParent {
    public $id;
    public $campaign_type_id;
    public $campaign_type_label;
    public $parent_campaign_type_id;
    public $parent_campaign_type_label;
    public $campaign_id;
    public $parent_campaign_id;
    public $start_date;
    public $end_date;
    public $is_active;
    /**
     * Constructor
     */
    public function __construct() {
        $this->id = 0;
        $this->campaign_type_id = 0;
        $this->campaign_type_label = "";
        $this->campaign_parent_type_id = 0;
        $this->campaign_parent_type_label = "";
        $this->campaign_id = 0;
        $this->campaign_parent_id = 0;
        $this->start_date = "";
        $this->end_date = "";
        $this->is_active = 0;
    }
    /**
     * Function to create a CampaignParentType
     * 
     * @author Erik Hommel (erik.hommel@civicoop.org)
     * @date 21 jan 2014
     * @param array $params
     * @throws Exception if mandatory param not found
     * @throws Exception if mandatory param is empty
     * @throws Exception if mandatory param is not numeric
     * @access public
     * @static
     */
    public static function createCampaignParentType($params) {
        CRM_Core_Error::debug("params", $params);
        $mandatory_params = array("campaign_type_id", "parent_campaign_type_id");
        foreach ($mandatory_params as $mandatory_param) {
            CRM_Core_Error::debug("params", $params);
            CRM_Core_Error::debug("mand", $mandatory_param);
            if (!array_key_exists($mandatory_param, $params)) {
                throw new Exception("Mandatory param ".$mandatory_param." is missing from array params");
            }
            if (empty($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." can not be empty");
            }
            if (!is_numeric($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." has to be numeric");
            }
        }
        $insert_query = "INSERT INTO civicrm_campaign_type_parent 
            SET campaign_type_id = {$params['campaign_type_id']}, 
            parent_campaign_type_id = {$params['parent_campaign_type_id']}";
        CRM_Core_DAO::executeQuery($insert_query); 
    }
    /**
     * Function to update an existing CampaingParentType record with a new parent
     * 
     * @author Erik Hommel (erik.hommel@civicoop.org)
     * @date 21 Jan 2014
     * @param array $params
     * @throws Exception if mandatory param not found
     * @throws Exception if mandatory param is empty
     * @throws Exception if mandatory param is not numeric
     * @access public
     * @static
     */
    public static function updateCampaignParentType($params) {
        $mandatory_params = array("campaign_type_id", "parent_campaign_type_id");
        foreach ($mandatory_params as $mandatory_param) {
            if (!array_key_exists($mandatory_param, $params)) {
                throw new Exception("Mandatory param ".$mandatory_param." is missing from array params");
            }
            if (empty($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." can not be empty");
            }
            if (!is_numeric($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." has to be numeric");
            }
        }
        $update_query = "UPDATE civicrm_campaign_type_parent 
            SET parent_campaign_type_id = {$params['parent_campaign_type_id']} 
                WHERE campaign_type_id = {$params['campaign_type_id']}";
        CRM_Core_DAO::executeQuery($update_query);         
    }
    /**
     * Function to create a campaign parent record
     * 
     * @author Erik Hommel (erik.hommel@civicoop.org)
     * @date 21 Jan 2014
     * @param array $params
     * @throws Exception if mandatory param not found
     * @throws Exception if mandatory param is empty
     * @throws Exception if mandatory param is not numeric
     * @access public
     */
    public function create($params) {
        $mandatory_params = array("campaign_id", "parent_campaign_id");
        foreach ($mandatory_params as $mandatory_param) {
            if (!in_array($mandatory_param, $params)) {
                throw new Exception("Mandatory param ".$mandatory_param." is missing from array params");
            }
            if (empty($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." can not be empty");
            }
            if (!is_numeric($params[$mandatory_param])) {
                throw new Exception("Param ".$mandatory_param." has to be numeric");
            }
        }
        $insert_fields = array();
        if (isset($params['campaign_id'])) {
            $this->campaign_id = $params['campaign_id'];
            $insert_fields[] = "campaign_id = {$this->campaign_id}";
        }
        if (isset($params['parent_campaign_id'])) {
            $this->parent_campaign_id = $params['parent_campaign_id'];
            $insert_fields[] = "parent_campaign_id = {$this->parent_campaign_id}";
        }
        if (isset($params['start_date'])) {
            $this->start_date = $params['start_date'];
            $start_date = date("Ymd", strtotime($this->start_date));
            $insert_fields[] = "start_date = '$start_date'";
        }
        if (isset($params['end_date'])) {
            $this->end_date = $params['end_date'];
            $end_date = date("Ymd", strtotime($this->end_date));
            $insert_fields[] = "end_date = '$end_date'";
        }
        if (!empty($insert_fields)) {
            $query = "INSERT INTO civicrm_campaign_parent SET ".implode(", ", $insert_fields);
            CRM_Core_DAO::executeQuery($query);
            $latest_query = "SELECT MAX(id) AS max_id FROM civicrm_campaign_parent";
            $dao_latest = CRM_Core_DAO::executeQuery($latest_query);
            if ($dao_latest->fetch()) {
                if (isset($dao_latest->max_id)) {
                    $this->id = $dao_latest->max_id;
                }
            }                    
        }
    }
    /**
     * Static function to retrieve the campaing type parent with the child
     * campaign id
     * 
     * @author Erik Hommel (erik.hommel@civicoop.org)
     * @date 14 Jan 2014
     * @param string $campaign_type_id
     * @throws Exception if campaign_type_id empty or not numeric
     * @return array $parent
     * @access public
     * @static
     */
    public static function getCampaignTypeParent($campaign_type_id) {
        $parent = array();
        if (empty($campaign_type_id)) {
            throw new Exception("Trying to get campaign type parent in function ".__FUNCTION__." with empty campaign_type_id");
        }
        if (!is_numeric($campaign_type_id)) {
            throw new Exception("Trying to get campaign type parent in function ".__FUNCTION__." with campaign_type_id that is not numeric");
        }
        $query = "SELECT * FROM civicrm_campaign_type_parent WHERE campaign_type_id = $campaign_type_id";
        $dao = CRM_Core_DAO::executeQuery($query);
        if ($dao->fetch()) {
            $parent['id'] = $dao->id;
            $parent['campaign_type_id'] = $dao->campaign_type_id;
            $parent['parent_campaing_type_id'] = $dao->parent_campaign_type_id;
        }
        return $parent;
    }
}
