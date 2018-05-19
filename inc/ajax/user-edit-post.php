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
echo 'test';
    http_response_code(404);
    exit;

}

check_login($PDO,$auth,array(0,1,3));

$return = array(
    "error" => true,
    "message" => ""
);


$userId = post("user_id");

try{

    $PDO->query("START TRANSACTION");

    if(post("user_old_statue") == "3" && post("user_old_statue") != post("user_statue")){

        if($PDO->query("SELECT * FROM `schools` WHERE `advisor_id` = {$userId}")->rowCount()){
            $return = array(
                "error" => true,
                "message" => "This Advisor Has Assigned To A School.Please Reassign Advisors School."
            );
            $PDO->query("ROLLBACK;");
            return_error($return);
        }

    }


    $PDO->query("UPDATE `phpauth_users` SET `is_individual` = null,`school_id` = null,`committee_id` = null,`country_id` = null WHERE `id` = {$userId} ");

    $updateArray = array();

    /*
     * THIS FORM IS SO DYNAMIC SO YOU MUST DYNAMICALLY CREATE INSERT CODE
     */

    $updateArray["name"] = ucfirst(post("user_name"));
    $updateArray["surname"] = ucfirst(post("user_last_name"));
    $updateArray["auth"] = post("user_statue");
    $updateArray["telephone"] = post("user_telephone");
    $updateArray["country"] = post("user_country");
    $updateArray["isactive"] = post("user_is_active");

    if(post("user_statue") == "4" ){

        $updateArray["country_id"] = post("user_represented_country_id");
        $updateArray["committee_id"]= post("user_committee_id");

    }else if(post("user_statue") == "2"){

        $updateArray["committee_id"] = post("user_committee_id");

    }else if(post("user_statue") == ("0"||"1") ){

        if(auth_level != "0"){
            $return = array(
                "error" => true,
                "message" => "Only Super Admins Can Edit Super Admins Or Moderators."
            );


        }

    }

    if(!empty(post("user_is_individual"))){
        if(post("user_is_individual") == "no"){
            $updateArray["is_individual"] = "0";
            $updateArray["school_id"] = post("user_school_id");
        }else if (post("user_is_individual") == "yes"){
            $updateArray["is_individual"] = "1";
        }

    }

    //IF AN ADVISOR TRYING TO EDIT A USER
    if(auth_level == "3"){
        $updateArray["auth"] = "4";
        $updateArray["country_id"] = post("user_represented_country_id");
        $updateArray["committee_id"]= post("user_committee_id");
        $updateArray["is_individual"] = "0";
        $updateArray["school_id"] = post("user_school_id");
        unset($updateArray["isactive"]);
    }

//    var_dump($updateArray);
//    exit;

    $mail = false;
    $password = null;
    if(!empty(post("user_password"))){
        if(post("user_send_mail") == "1"){
            $mail=true;
        }
        $password = post("user_password");

        $zxcvbn = new Zxcvbn();

        if ($zxcvbn->passwordStrength($password)['score'] < intval($auth->config->password_min_score)) {
            $return = array(
                "error" => true,
                "message" => "Password Is Too Weak."
            );
            $PDO->query("ROLLBACK;");
            return_error($return);

        }

        $updateArray["password"] = $auth->getHash($password);

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

    /*
     *
     * MAIL
     */
    //IF $mail == FALSE JUST GIVE INFORMATION ABOUT THE RESULT
    if($mail==false){
        $return["error"] = false;
        $return["message"] = "User sucessfully Edited.<br> Email: ".post("user_email")."<br> Password :".@$password."<br>";
        $PDO->query("COMMIT");
        return_error($return);
    }

    /*
     * MAIL USER HIS LOGIN INFO
     */
    $phpmailer->addAddress(post("user_email"), ucfirst(post("name")." ".post("last_name")));
    $phpmailer->isHTML(true);

    //EMAIL TEMPLATE PROVIDED FROM config.php
    $phpmailer->Subject = $addeditSubject;
    $phpmailer->Body    = sprintf($addEditUserMail,@post("user_email"),@$password);
    $phpmailer->CharSet = 'UTF-8';

    //HANDLE PHPMAILER ERROR
    if(!$phpmailer->send()) {
        $return["error"] = true;
        $return["message"] = $phpmailer->ErrorInfo;
        $PDO->query("ROLLBACK");
        return_error($return);
    }

    /*
     *
     * MAIL
     */


    $PDO->query("COMMIT;");

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
    $PDO->query("ROLLBACK;");
    return_error($return);

} catch (Exception $e) {

    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    $PDO->query("ROLLBACK;");
    return_error($return);
}