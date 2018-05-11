<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 18:26
 */

include '../loader.php';

if(empty(post("school_name")) || empty(post("advisor_id")) || empty($_POST["quotas"])){

    http_response_code(404);
    exit;
    
}


$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->query("START TRANSACTION");

    $PDO->prepare("INSERT INTO `schools` SET `school_name` = :school_name, `advisor_id` = :advisor_id,`country_id`=:country_id ")
        ->execute(array(
            "school_name" => trim(post("school_name")),
            "advisor_id" => post("advisor_id"),
            "country_id" => post("school_country_id")

        ));

    $school_id = $PDO->lastInsertId();

    $PDO->query("DELETE FROM `committee_structure` WHERE `school_id`='{$school_id}' ");

    foreach($_POST["quotas"] as $key => $value){

        if($value["quota"] > 0){

            $PDO->prepare("INSERT INTO `committee_structure` SET `committee_id` = :committee_id, `country_id` = :country_id , `school_id` = :school_id , `quota` = :quota")
                ->execute(array(
                    "committee_id" => $key,
                    "country_id" => $value["country"],
                    "school_id" => $school_id,
                    "quota" => $value["quota"]
                ));

        }

    }

    $PDO->query("UPDATE `phpauth_users` SET `isactive` = 1 WHERE `id` = '{$_POST["advisor_id"]}' ");

    $return = array(
        "error" => false,
        "message" => "School Succesfully Added."
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

