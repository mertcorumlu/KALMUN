<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 01:55
 */

//LOAD APP
include("../loader.php");


if(!$_POST){
    http_response_code(404);
}


    //TYPE 1 = School Registration
    //TYPE 2 = Individual Registration
    //TYPE 3 = ICJ Registration
    //TYPE 4 = Press Application

    //SET RETURN ARRAY
    $return = array(
        "return" => true,
        "message"=> ""
    );

    //YOU MUST CHECK APPLICATION TYPE AND TAKE PARAMETERS AS IT
    if(post("application_type") == "1"){

        try{
            //SET EMAIL INTO A VARIABLE
            $email = post("school_reg_contact_mail");

            //START MYSQL TRANSACTION
            $PDO->query("START TRANSACTION;");

            //CHECK IF USER ALREADY APPLIED WITH THIS EMAIL
            $query = $PDO->query("SELECT 
                                           * 
                                           FROM 
                                           `applications`,`phpauth_users` 
                                           WHERE 
                                           applications.email = '{$email}' 
                                           OR 
                                           phpauth_users.email = '{$email}' 
                                           ");

            //IF THERE IS AN APPLICATION WITH THIS EMAIL,DONT LET HIM APPLY AGAIN
            if($query->rowCount() >= 1){
                $return["error"] = true;
                $return["message"] = "You have already applied with this email.";
                $PDO->query("ROLLBACK;");
                return_error($return);
            }

            //WE DONT NEED $QUERY ANYMORE,JUST SET IT NULL
            $query = null;


            //INSERT APPLICATION
            $prepare = $PDO->prepare("INSERT INTO `applications` SET 
                                              `type` = :type , 
                                              `name` = :name, 
                                              `last_name` = :last_name, 
                                              `school` = :school, 
                                              `country` = :country, 
                                              `email` = :email, 
                                              `telephone` = :telephone, 
                                              `data` = :data, 
                                              `status` = 0");

            //EXECUTE
            $prepare->execute(array(
                "type" => post("application_type"),
                "name" => ucfirst(post("data")["school_reg_advisor_name"]),
                "last_name" => ucfirst(post("data")["school_reg_advisor_last_name"]),
                "school" => ucfirst(post("school_reg_name_of_school")),
                "country" => post("data")["school_reg_country"],
                "email" => post("school_reg_contact_mail"),
                "telephone" => post("school_reg_contact_phone"),
                "data" => json_encode(post("data"))

            ));

            //DISPLAY MESSAGE TO INFORM USER ABOUT SUCCESSION
            $return["return"] = false;
            $return["message"] = "You Have Succesfully Applied.Your Submission Will Be Evaluated Within a Week.";
            return_error($return);


        }catch (PDOException $e){
            //HANDLE SQL ERRORS
            $return["error"] = true;
            $return["message"] = $e->errorInfo[2];
            $PDO->query("ROLLBACK;");
            return_error($return);
        }

    }
    else if (post("application_type") == "2"){

        try{
            //SET EMAIL
            $email = post("ind_reg_contact_mail");

            //START SQL TRANSACTION
            $PDO->query("START TRANSACTION;");

            //CHECK IF USER APPLIED WITH THIS EMAIL BEFORE
            $query = $PDO->query("SELECT * 
                                           FROM 
                                           `applications`,`phpauth_users`
                                           WHERE 
                                           applications.email = '{$email}' 
                                           OR 
                                           phpauth_users.email = '{$email}' ");

            //IF EMAIL IS EXIST,DONT LET HIM APPLY
            if($query->rowCount() >= 1){
                $return["error"] = true;
                $return["message"] = "You have already applied with this email.";
                $PDO->query("ROLLBACK;");
                return_error($return);
            }

            //YOU DONT NEED $QUERY ANYMORE ,SET IT NULL
            $query = null;

            //INSERT APPLICATION
            $prepare = $PDO->prepare("INSERT INTO `applications` SET 
                                              `type` = :type , 
                                              `name` = :name, 
                                              `last_name` = :last_name, 
                                              `school` = :school, 
                                              `country` = :country, 
                                              `email` = :email, 
                                              `telephone` = :telephone, 
                                              `data` = :data, 
                                              `status` = 0");

            //EXECUTE INSERTION
            $prepare->execute(array(
                "type" => post("application_type"),
                "name" => ucfirst(post("ind_reg_name")),
                "last_name" => ucfirst(post("ind_reg_last_name")),
                "school" => ucfirst(post("ind_reg_name_of_school")),
                "country" => $_POST["data"]["ind_reg_country"],
                "email" => post("ind_reg_contact_mail"),
                "telephone" => post("ind_reg_contact_phone"),
                "data" => json_encode($_POST["data"])

            ));



            //RETURN IF NO ERROR
            $return["return"] = false;
            $return["message"] = "You Have Succesfully Applied.Your Submission Will Be Evaluated Within a Week.";
            return_error($return);


        }catch (PDOException $e){
            $return["error"] = true;
            $return["message"] = $e->errorInfo[2];
            $PDO->query("ROLLBACK;");
            return_error($return);
        }

    }



