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
if(empty($_POST["id"]) ){
    echo 'test';
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(2));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->beginTransaction();

    $userData = $PDO->query("
                          SELECT 
                          phpauth_users.`id`,
                          phpauth_users.committee_id
                          FROM 
                          `phpauth_users` 
                          WHERE 
                          phpauth_users.id = '".$auth->getCurrentUID()."'")
        ->fetch(PDO::FETCH_ASSOC) ;


    $PDO->query("
                UPDATE
                `files`
                SET
                is_reso = 0
                WHERE
                committee_id = '{$userData["committee_id"]}'
                
        ");





        $PDO->query("
                    UPDATE
                    `files`
                    SET
                    is_reso = 1
                    WHERE
                    status = 5
                    AND
                    committee_id = '{$userData["committee_id"]}'
                    AND
                    id = '{$_POST["id"]}'
    ");



    $return = array(
        "error" => false,
        "message" => "Resolution Sucessfuly Selected"
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