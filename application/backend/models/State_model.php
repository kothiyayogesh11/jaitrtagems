<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 9/21/2017
 * Time: 10:26 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class state_model extends Data {

    function __construct()
    {
        parent::__construct();
        $this->tbl = 'state_master';
    }

    function getStateList()
    {
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = "sm.*,cm.country_id,cm.country_name";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
        {
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = "WHERE 1=1 ";

        // By state name
        if(isset($searchCriteria['state_name']) && $searchCriteria['state_name'] != "")
        {
            $whereClaue .= 	" AND sm.state_name='".$searchCriteria['state_name']."' ";
        }

        // Not In
        if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
        {
            $whereClaue .= 	" AND state_id !=".$searchCriteria['not_id']." ";
        }

        $orderField = " sm.state_name";
        $orderDir = " ASC";

        // Set Order Field
        if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
        {
            $orderField = $searchCriteria['orderField'];
        }

        // Set Order Field
        if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
        {
            $orderDir = $searchCriteria['orderDir'];
        }

        $sqlQuery = "SELECT ".$selectField." FROM state_master AS sm JOIN country_master AS cm
							ON cm.country_id = sm.country_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";

        //echo $sqlQuery; exit;
        $result     = $this->db->query($sqlQuery);
        $rsData     = $result->result_array();
        return $rsData;
    }
}