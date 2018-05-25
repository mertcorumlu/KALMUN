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
if(empty(post("country_name")) || empty(post("country_iso")) || empty(post("country_id")) ){
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

    $country_id = post("country_id");

    //UPDATE SCHOOL INFO
    $PDO->prepare("UPDATE `countries` SET `country_name` = :country_name,`flag` = :country_iso WHERE `id` = :id ")
        ->execute(array(
            "country_name" => ucfirst(trim(post("country_name"))),
            "country_iso" => strtoupper(post("country_iso")),
            "id" => $country_id

        ));


    //RETURN SUCCEESS IF NO ERROR
    $return = array(
        "error" => false,
        "message" => "Country Succesfully Edited."
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

