<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 09:37
 */

//LOAD APP
include("../loader.php");

//CHECK IF REQUEST IS WORNG
if(get("id")== "" || get("value")== ""){
    http_response_code(404);
    exit;
}

//ARRAY THAT RETURNS MESSAGE
$return = array(
    "return" => true,
    "message" => "",
    "state" => "",
    "id" => ""
);


//CHECK IF USER REALLY LOGGED IN OR AUTHORIZED
check_login($PDO,$auth,array(0,1));

try {

        //REQUIRED VARIABLES
        $id = get("id");
        $value = get("value");
        $return["state"] = $value;
        $return["id"] = $id;

        //START SQL TRANSACTION
        $PDO->query("START TRANSACTION");

        //UPDATE APPLICATION STATE
        $PDO->query("UPDATE `applications` SET `status`='{$value}' WHERE `id`='{$id}' ");

        //SELECT THE PROVIDED APPLICATION AND CREATE NEW USER WITH APPLICATION INFORMATION OR SEND MAIL
        $fetch = $PDO->query("SELECT * FROM `applications` WHERE  `id` = '{$id}'")->fetch(PDO::FETCH_ASSOC);

        //IF APPLICATION APPROVED CREATE NEW USER
        if($value == "1"){

            //CREATE A RANDOM PASSWORD
            $password = random_string(10);

            //REGISTER WITH PHPAuth
            $register_eror = $auth->register($fetch["email"],$password,$password,array(
                "auth"=>$Application_Auth[$fetch["type"]],
                "name" =>$fetch["name"],
                "surname" => $fetch["last_name"],
                "country" => $fetch["country"],
                "telephone" => $fetch["telephone"],
                /* YOU MUST SET ISACTIVE FIELD TO 0 BECAUSE NEW REGISTERED USERS CANNOT USE SYSTEM IF THEY DONT HAVE A COMMITTEE */
                "isactive" => 0

            ));

            //HANDLE ERROR
            if($register_eror["error"] == true){
                $return["error"] = true;
                $return["message"] = $register_eror["message"];
                $PDO->query("ROLLBACK");
                return_error($return);
            }

        }

        //IF SENDMAIL == FALSE JUST GIVE INFORMATION ABOUT THE RESULT
        if(get("sendEmail")=="false"){
            $return["return"] = false;
            $return["message"] = "Applicaton state successfully saved.".($value == 1 ?"<br>User sucessfully created.<br> Email: ".$fetch["email"]."<br> Password :".$password:"");
            $PDO->query("COMMIT");
            return_error($return);
        }

        /*
         * MAIL USER HIS LOGIN INFO
         */
        $phpmailer->addAddress($fetch["email"], ucfirst($fetch["name"]." ".$fetch["last_name"]));
        $phpmailer->isHTML(true);

        //EMAIL TEMPLATE PROVIDED FROM config.php
        $phpmailer->Subject = $mail_type[$value]["subject"];
        $phpmailer->Body    = sprintf($mail_type[$value]["body"],@$fetch["email"],@$password);
        $phpmailer->CharSet = 'UTF-8';

        //HANDLE PHPMAILER ERROR
        if(!$phpmailer->send()) {
            $return["error"] = true;
            $return["message"] = $phpmailer->ErrorInfo;
            $PDO->query("ROLLBACK");
            return_error($return);
        }


        //IF EVERYTHING WENT RIGHT,JUST INFORM USER
        $return["return"] = false;
        $return["message"] = "Applicaton state successfully saved.<br>Successfully mailed.".($value == 1 ?"<br><br>User sucessfully created.<br> Email: ".$fetch["email"]."<br> Password :".$password:"");
        $PDO->query("COMMIT");
        return_error($return);


}catch (PDOException $e){
    //HANDLE SQL ERRORS
    $return["error"] = true;
    $return["message"] = $e->errorInfo[2];
    $PDO->query("ROLLBACK");
    return_error($return);
}catch(Exception $e){
    //HANDLE PHPMAILER ERRORS
    $return["error"] = true;
    $return["message"] = $e->getMessage();
    $PDO->query("ROLLBACK");
    return_error($return);
}