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
if(empty(post("committee_name")) || empty(post("committee_id")) ){
    http_response_code(404);
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
    $PDO->query("START TRANSACTION");

    $committee_id = post("committee_id");

    //UPDATE SCHOOL INFO
    $PDO->prepare("UPDATE `committees` SET `committee_name` = :committee_name WHERE `id`=:id ")
        ->execute(array(
            "committee_name" => ucfirst(trim(post("committee_name"))),
            "id" => $committee_id

        ));


    //RETURN SUCCEESS IF NO ERROR
    $return = array(
        "error" => false,
        "message" => "Committee Succesfully Edited."
    );
    $PDO->query("COMMIT;");
    return_error($return);



}catch(PDOException $e){
    //HANDLE SQL ERROR
    $return = array(
        "error" => true,
        "message" => $e->errorInfo[2]
    );
    $PDO->query("ROLLBACK;");
    return_error($return);

}

exit;

