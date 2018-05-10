<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 09:37
 */
include("../loader.php");

if(get("id")== "" || get("value")== ""){
    http_response_code(404);
    exit;
}

$return = array(
    "return" => true,
    "message" => "",
    "state" => "",
    "id" => ""
);

check_login($PDO,$auth,array(0,1));

try {
    $id = get("id");
    $value = get("value");
    $return["state"] = $value;
    $return["id"] = $id;


    $PDO->query("START TRANSACTION");
    $PDO->query("UPDATE `applications` SET `status`='{$value}' WHERE `id`='{$id}' ");
    $fetch = $PDO->query("SELECT * FROM `applications` WHERE  `id` = '{$id}'")->fetch(PDO::FETCH_ASSOC);

    if($value == "1"){

        $password = random_string(10);

        $register_eror = $auth->register($fetch["email"],$password,$password,array(
            "auth"=>$Application_Auth[$fetch["type"]],
            "name" =>$fetch["name"],
            "surname" => $fetch["last_name"],
            "country" => $fetch["country"],
            "telephone" => $fetch["telephone"],
            "isactive" => 0
        ));

        if($register_eror["return"] == true){
            $return["message"] = $register_eror["message"];
            $PDO->query("ROLLBACK");
            return_error($return);
        }

    }


    if(get("sendEmail")=="false"){
        $return["return"] = false;
        $return["message"] = "Applicaton state successfully saved.".($value == 1 ?"<br>User sucessfully created.<br> Email: ".$fetch["email"]."<br> Password :".$password:"");
        $PDO->query("COMMIT");
        return_error($return);
    }

    $phpmailer->addAddress($fetch["email"], mb_strtoupper($fetch["name"]." ".$fetch["last_name"]));
    $phpmailer->isHTML(true);
    $phpmailer->Subject = $mail_type[$value]["subject"];
    $phpmailer->Body    = sprintf($mail_type[$value]["body"],@$fetch["email"],@$password);
    $phpmailer->CharSet = 'UTF-8';

    if(!$phpmailer->send()) {
        $return["message"] = $phpmailer->ErrorInfo;
        $PDO->query("ROLLBACK");
        return_error($return);
    }

    $return["return"] = false;
    $return["message"] = "Applicaton state successfully saved.<br>Successfully mailed.".($value == 1 ?"<br><br>User sucessfully created.<br> Email: ".$fetch["email"]."<br> Password :".$password:"");
    $PDO->query("COMMIT");
    return_error($return);

}catch (PDOException $e){
    $return["message"] = $e->errorInfo[2];
    $PDO->query("ROLLBACK");
    return_error($return);
}catch(Exception $e){
    $return["message"] = $e->getMessage();
    $PDO->query("ROLLBACK");
    return_error($return);
}