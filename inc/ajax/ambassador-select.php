<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 29/05/2018
 * Time: 01:34
 */

//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if(empty($_POST["user_name"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(3));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->beginTransaction();

    $userData = $PDO->query("
                          SELECT 
                          phpauth_users.`id`,
                          schools.id as advisor_school
                          FROM 
                          `phpauth_users` 
                          LEFT JOIN
                          `schools`
                          ON
                          schools.advisor_id = phpauth_users.id
                          OR 
                          schools.id = phpauth_users.school_id
                          WHERE 
                          phpauth_users.id = '".$auth->getCurrentUID()."'")
                                                     ->fetch(PDO::FETCH_ASSOC) ;


    $PDO->query("
                UPDATE
                `phpauth_users`
                SET
                is_amb = 1
                WHERE
                school_id = {$userData["advisor_school"]}
                AND 
                auth = 4
                
        ");



    foreach ($_POST["user_name"] as $value ){

    $PDO->query("
                    UPDATE
                    `phpauth_users`
                    SET
                    is_amb = 1
                    WHERE
                    auth = 4
                    AND
                    school_id = {$userData["advisor_school"]}
                    AND
                    id =({$value}) 
    ");

    }

    $return = array(
        "error" => false,
        "message" => "Ambassador(s) Sucessfuly Selected"
    );

    $PDO->commit();
    return_error($return);

}catch (PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    $PDO->rollback();
    return_error($return);
}