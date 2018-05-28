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
    if(empty(post("school_name")) || empty(post("advisor_id")) || empty($_POST["quotas"])){
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

        $school_id = post("school_id");

        //UPDATE SCHOOL INFO
        $PDO->prepare("UPDATE `schools` SET `school_name` = :school_name, `advisor_id` = :advisor_id WHERE `id`=:id ")
            ->execute(array(
                "school_name" => ucfirst(trim(post("school_name"))),
                "advisor_id" => post("advisor_id"),
                "id" => $school_id

            ));


        //DELETE ALL OTHER SCHOOL COMITTEE STRUCTURE
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

        //RETURN SUCCEESS IF NO ERROR
        $return = array(
            "error" => false,
            "message" => "School Succesfully Edited."
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

