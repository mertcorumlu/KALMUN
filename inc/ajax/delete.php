<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 28/05/2018
 * Time: 19:12
 */

include '../loader.php';

if(empty( get("type") || get("id") )){

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

    switch (get("type")){

        case "application":
            $query = "DELETE FROM `applications` WHERE `id` ='{$_GET["id"]}'";
        break;

        case "committee";
            $query = "DELETE FROM `committees` WHERE `id` ='{$_GET["id"]}'";
        break;

        case "country";
            $query = "DELETE FROM `countries` WHERE `id` ='{$_GET["id"]}'";
        break;

        case "school";
            $query = "DELETE FROM `schools` WHERE `id` ='{$_GET["id"]}'";
        break;

        case "user";
            $query = "DELETE FROM `phpauth_users` WHERE `id` ='{$_GET["id"]}'";
        break;

    }

    $PDO->query(@$query);

    $return = array(
        "error" => false,
        "message" => ucfirst(get("type"))." Succesfully Deleted."
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