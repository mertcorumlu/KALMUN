<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 18:26
 */

include '../loader.php';

if(empty(post("country_name")) || empty(post("country_iso"))){

    http_response_code(400);
    exit;

}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->beginTransaction();

    $PDO->prepare("INSERT INTO `countries` SET `country_name` = :country_name , `flag` = :country_iso")
        ->execute(array(
            "country_name" => ucfirst(trim(post("country_name"))),
            "country_iso" => strtoupper(post("country_iso"))
        ));


    $return = array(
        "error" => false,
        "message" => "Country Succesfully Added."
    );
    $PDO->commit();
    return_error($return);



}catch(PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    $PDO->rollback();
    return_error($return);

}

