<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 18:26
 */

include '../loader.php';

if(empty(post("session_name")) || empty(post("session_start")) || empty(post("session_end"))){

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

    $PDO->prepare("INSERT INTO `sessions` SET `session_name` = :country_name , `session_start` = :session_start, `session_end` = :session_end")
        ->execute(array(
            "country_name" => ucfirst(trim(post("session_name"))),
            "session_start" => post("session_start"),
            "session_end" => post("session_end"),
        ));


    $return = array(
        "error" => false,
        "message" => "Session Succesfully Added."
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

