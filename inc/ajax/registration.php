<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 01:55
 */

if($_POST){
    include("../loader.php");

    //TYPE 1 = School Registration
    //TYPE 2 = Individual Registration
    //TYPE 3 = ICJ Registration
    //TYPE 4 = Press Application

    $error = array(
        "return" => true,
        "message"=> ""
    );

    if(post("application_type") == "1"){

        print_r(post("data"));
        exit;

        try{
            $email = post("school_reg_contact_mail");

            $query = $PDO->query("SELECT * FROM `applications`,`phpauth_users` WHERE applications.email = '{$email}' OR phpauth_users.email = '{$email}' ");

            if($query->rowCount() >= 1){
                $error["message"] = "You have already applied with this email.";
                return_error($error);
            }

            $query = null;

           // print_r($_POST);exit;


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

            $prepare->execute(array(
                "type" => post("application_type"),
                "name" => post("data")["school_reg_advisor_name"],
                "last_name" => post("data")["school_reg_advisor_last_name"],
                "school" => post("school_reg_name_of_school"),
                "country" => post("data")["school_reg_country"],
                "email" => post("school_reg_contact_mail"),
                "telephone" => post("school_reg_contact_phone"),
                "data" => json_encode(post("data"))

            ));

            $error["return"] = false;
            $error["message"] = "You Have Succesfully Applied.Your Submission Will Be Evaluated Within a Week.";
            return_error($error);


        }catch (PDOException $e){
                $error["message"] = $e->errorInfo[2];
                return_error($error);
        }

    }
    else if (post("application_type") == "2"){
       // print_r($_POST);exit;
        try{
            $email = post("ind_reg_contact_mail");

            $query = $PDO->query("SELECT * 
                                           FROM 
                                           `applications`,`phpauth_users`
                                           WHERE 
                                           applications.email = '{$email}' 
                                           OR 
                                           phpauth_users.email = '{$email}' ");

            if($query->rowCount() >= 1){
                $error["message"] = "You have already applied with this email.";
                return_error($error);
            }

            $query = null;




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

            $prepare->execute(array(
                "type" => post("application_type"),
                "name" => post("ind_reg_name"),
                "last_name" => post("ind_reg_last_name"),
                "school" => post("ind_reg_name_of_school"),
                "country" => $_POST["data"]["ind_reg_country"],
                "email" => post("ind_reg_contact_mail"),
                "telephone" => post("ind_reg_contact_phone"),
                "data" => json_encode($_POST["data"])

            ));



            $error["return"] = false;
            $error["message"] = "You Have Succesfully Applied.Your Submission Will Be Evaluated Within a Week.";
            return_error($error);


        }catch (PDOException $e){
            $error["message"] = $e->errorInfo[2];
            return_error($error);
        }

    }



}