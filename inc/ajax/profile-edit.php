<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 11/05/2018
 * Time: 19:09
 */

use ZxcvbnPhp\Zxcvbn;

include '../loader.php';

if(!$_POST){
    http_response_code(400);
    exit;

}

check_login($PDO,$auth,array(0,1,2,3,4));

$return = array(
    "error" => true,
    "message" => ""
);


$userId = $auth->getCurrentUID();


try{

    $PDO->beginTransaction();

    $updateArray = array();

    /*
     * THIS FORM IS SO DYNAMIC SO YOU MUST DYNAMICALLY CREATE INSERT CODE
     */

    $updateArray["name"] = ucfirst(post("user_name"));
    $updateArray["surname"] = ucfirst(post("user_last_name"));
    $updateArray["email"] = post("user_email");
    $updateArray["telephone"] = post("user_telephone");
    $updateArray["country"] = post("user_country");

    if( !empty(post("user_password")) && !empty(post("user_password_repeat")) ){

        if( post("user_password") != post("user_password_repeat") ){
            $return = array(
                "error" => true,
                "message" => "Passwords Did Not Match"
            );
            $PDO->rollback();
            return_error($return);
        }

        $zxcvbn = new Zxcvbn();
        if ($zxcvbn->passwordStrength(post("user_password"))['score'] < intval($auth->config->password_min_score)) {
            $return = array(
                "error" => true,
                "message" => "Password Is Too Weak"
            );
            $PDO->rollback();
            return_error($return);

        }

        $updateArray["password"] = $auth->getHash(post("user_country"));

    }


    $update = array();
    foreach($updateArray as $a => $b){
        array_push($update,"`".$a.'` = "'.$b.'"');
    }

    $query = "
    UPDATE
  `phpauth_users`
    SET
    ".implode(',',$update)."
    WHERE
  `id` = {$userId}
    ";
    $PDO->query($query);



    $PDO->commit();

    $return = array(
        "error" => false,
        "message" => "User Succesfully Edited. Mail Sent."
    );
    return_error($return);


}catch(PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    $PDO->rollback();
    return_error($return);

}