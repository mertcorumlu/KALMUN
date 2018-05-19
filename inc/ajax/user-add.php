<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 11/05/2018
 * Time: 19:09
 */

include '../loader.php';

if(!$_POST){

    http_response_code(404);
    exit;

}

check_login($PDO,$auth,array(0,1,3));

$return = array(
    "error" => true,
    "message" => ""
);

try{


    $PDO->query("START TRANSACTION");

    $insertArray = array();

    /*
     * THIS FORM IS SO DYNAMIC SO YOU MUST DYNAMICALLY CREATE INSERT CODE
     */

    $insertArray["name"] = ucfirst(post("user_name"));
    $insertArray["surname"] = ucfirst(post("user_last_name"));
    $insertArray["auth"] = post("user_statue");
    $insertArray["telephone"] = post("user_telephone");
    $insertArray["country"] = post("user_country");
    $insertArray["isactive"] = post("user_is_active");

    if(post("user_statue") == "4" ){

        $insertArray["country_id"] = post("user_represented_country_id");
        $insertArray["committee_id"]= post("user_committee_id");

    }else if(post("user_statue") == "2"){

        $insertArray["committee_id"] = post("user_committee_id");

    }else if(post("user_statue") == ("0"||"1") ){

        if(auth_level != "0"){
            $return = array(
                "error" => true,
                "message" => "Only Super Admins Can Add Super Admins Or Moderators."
            );


        }

    }

    if(!empty(post("user_is_individual"))){
        if(post("user_is_individual") == "no"){

            $insertArray["is_individual"] = "0";
            $insertArray["school_id"] = post("user_school_id");

        }

    }

    //IF AN ADVISOR TRYING TO CREATE A USER
    if(auth_level == "3"){
        $insertArray["auth"] = "4";
        $insertArray["isactive"] = "0";
        $insertArray["country_id"] = post("user_represented_country_id");
        $insertArray["committee_id"]= post("user_committee_id");
        $insertArray["is_individual"] = "0";
        $insertArray["school_id"] = post("user_school_id");
    }



    $mail = false;
    $password = "";
    if(!empty(post("user_password"))){
        $password = post("user_password");
        if(post("user_send_mail") == "1"){
            $mail=true;
        }
    }else{
        $mail=true;
        $password = random_string(8);
    }

    $return = $auth->register(post("user_email"),$password,$password,$insertArray);


    //HANDLE REGISTER ERRORS
    if($return["error"]==true){
        $PDO->query("ROLLBACK;");
        return_error($return);
    }


    /*
     *
     * MAIL
     */
    //IF $mail == FALSE JUST GIVE INFORMATION ABOUT THE RESULT
    if($mail==false){
        $return["return"] = false;
        $return["message"] = "User sucessfully created.<br> Email: ".post("user_email")."<br> Password :".$password;
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
        "message" => "User sucessfully created.Email Sent"
    );
    return_error($return);


}catch(PDOException $e){

    $return = array(
        "error" => true,
        "message" => $e->errorInfo[2]
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
