<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 18:26
 */

include '../loader.php';

if(empty(post("committee_name"))){

    http_response_code(404);
    exit;

}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->query("START TRANSACTION");

    $PDO->prepare("INSERT INTO `committees` SET `committee_name` = :committee_name")
        ->execute(array(
            "committee_name" => ucfirst(trim(post("committee_name")))


        ));


    $return = array(
        "error" => false,
        "message" => "Committee Succesfully Added."
    );
    $PDO->query("COMMIT;");
    return_error($return);



}catch(PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->errorInfo[2]
    );
    $PDO->query("ROLLBACK;");
    return_error($return);

}

