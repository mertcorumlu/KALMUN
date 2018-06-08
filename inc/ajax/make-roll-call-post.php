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
if(empty($_POST["user_status"]) || empty($_POST["session_id"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1,2));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    $PDO->beginTransaction();



    if(auth_level == "2"){
        $query_string = "(SELECT committee_id FROM phpauth_users WHERE id = '{$auth->getCurrentUID()}')";
    }else{

        if(!empty($_POST["committee_id"])){
            $query_string = $_POST["committee_id"];
        }else{
            echo 'test';
            http_response_code(400);
            $PDO->rollBack();
            exit;
        }

    }


    $PDO->query("
DELETE roll_calls
FROM
  roll_calls
LEFT JOIN
  phpauth_users
ON
  phpauth_users.id = roll_calls.user_id
WHERE
  roll_calls.session_id = '{$_POST["session_id"]}'
  AND
  phpauth_users.auth = 4
AND
  phpauth_users.committee_id = {$query_string}
    ");

    foreach($_POST["user_status"] as $userID => $status ){

        $PDO->prepare("INSERT INTO roll_calls SET session_id = :session_id, user_id = :user_id, status = :status ")
            ->execute(array(
                "session_id" => $_POST["session_id"],
                "user_id" => $userID,
                "status" => $status
            ));

    }

    $return = array(
        "error" => false,
        "message" => "Roll Call Sucessfully Submitted"
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