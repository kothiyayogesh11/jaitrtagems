<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 9/21/2017
 * Time: 10:26 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class country_model extends Data {

    function __construct()
    {
        parent::__construct();
        $this->tbl = 'country_master';
    }

    function getCountryList()
    {
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = "*";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
        {
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = "WHERE 1=1 ";

        // By country name
        if(isset($searchCriteria['country_name']) && $searchCriteria['country_name'] != "")
        {
            $whereClaue .= 	" AND cm.country_name='".$searchCriteria['country_name']."' ";
        }

        // Not In
        if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
        {
            $whereClaue .= 	" AND country_id !=".$searchCriteria['not_id']." ";
        }

        $orderField = " cm.country_name";
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

        $sqlQuery = "SELECT ".$selectField." FROM country_master AS cm ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";

        //echo $sqlQuery; exit;
        $result     = $this->db->query($sqlQuery);
        $rsData     = $result->result_array();
        return $rsData;
    }
}