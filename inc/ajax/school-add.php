<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 18:26
 */

include '../loader.php';

if(empty(post("school_name")) || empty(post("advisor_id")) || empty($_POST["quotas"])){

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

    $PDO->prepare("INSERT INTO `schools` SET `school_name` = :school_name, `advisor_id` = :advisor_id")
        ->execute(array(
            "school_name" => ucfirst(trim(post("school_name"))),
            "advisor_id" => post("advisor_id")

        ));

    $school_id = $PDO->lastInsertId();

    $PDO->query("DELETE FROM `committee_structure` WHERE `school_id`='{$school_id}' ");

    foreach($_POST["quotas"] as $key => $value) {

        foreach ($value["country"] as $a => $b) {

            if (($value["quota"][$a] > 0 && !empty($value["quota"][$a])) && (!empty($b) && $b > 0) ) {


                $PDO->prepare("INSERT INTO `committee_structure` SET `committee_id` = :committee_id, `country_id` = :country_id , `school_id` = :school_id , `quota` = :quota")
                    ->execute(array(
                        "committee_id" => $key,
                        "country_id" => $b,
                        "school_id" => $school_id,
                        "quota" => $value["quota"][$a]
                    ));

            }
        }

    }

    //    $PDO->query("UPDATE `phpauth_users` SET `isactive` = 1,`country_id` = '".post("school_country_id")."',`school_id` = {$school_id} WHERE `id` = '{$_POST["advisor_id"]}' ");

    $return = array(
        "error" => false,
        "message" => "School Succesfully Added."
    );
    $PDO->commit();
    return_error($return);



}catch(PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->errorInfo[2]
    );

    $PDO->rollback();
    return_error($return);
    
}

