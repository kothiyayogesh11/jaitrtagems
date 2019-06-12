<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 9/21/2017
 * Time: 10:26 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class city_model extends Data {

    function __construct()
    {
        parent::__construct();
        $this->tbl = 'city_master';
    }

    function getCityList()
    {
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = "ctm.*,cm.country_id,cm.country_name,sm.state_id,sm.state_name";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
        {
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = "WHERE 1=1 ";

        // By city name
        if(isset($searchCriteria['city_name']) && $searchCriteria['city_name'] != "")
        {
            $whereClaue .= 	" AND ctm.city_name='".$searchCriteria['city_name']."' ";
        }

        // Not In
        if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
        {
            $whereClaue .= 	" AND city_id !=".$searchCriteria['not_id']." ";
        }

        $orderField = " ctm.city_name";
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

        $sqlQuery = "SELECT ".$selectField." FROM city_master AS ctm JOIN country_master AS cm
							ON cm.country_id = ctm.country_id JOIN state_master AS sm
							ON sm.state_id = ctm.state_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";

        //echo $sqlQuery; exit;
        $result     = $this->db->query($sqlQuery);
        $rsData     = $result->result_array();
        return $rsData;
    }
}