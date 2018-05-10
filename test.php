<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 17:20
 */

/*

0 id li komitded 0 idli ülkeden 5 temsilci


 */
$array = array(
    array("country_id" => 1,"quantity" => 5),
    array("country_id" => 1,"quantity" => 5)
);

echo json_encode($array,true);