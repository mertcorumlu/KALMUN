<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 11/05/2018
 * Time: 10:09
 */

//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if(empty(post("session_id")) || empty(post("session_name")) || empty(post("session_start")) || empty(post("session_end")) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1));


//SET RETURN ARRAY
$return = array(
    "error" => true,
    "message" => ""
);

try{

    //START TRANSACTION
    $PDO->beginTransaction();



    //UPDATE SCHOOL INFO
    $PDO->prepare("UPDATE `sessions` SET `session_name` = :country_name , `session_start` = :session_start, `session_end` = :session_end
                            WHERE id = :session_id ")
        ->execute(array(
            "country_name" => ucfirst(trim(post("session_name"))),
            "session_start" => post("session_start"),
            "session_end" => post("session_end"),
            "session_id" => post("session_id"),
        ));


    //RETURN SUCCEESS IF NO ERROR
    $return = array(
        "error" => false,
        "message" => "Session Succesfully Edited."
    );
    $PDO->commit();
    return_error($return);



}catch(PDOException $e){
    //HANDLE SQL ERROR
    $return = array(
        "error" => true,
        "message" => $e->errorInfo[2]
    );
    $PDO->rollback();
    return_error($return);

}

exit;

