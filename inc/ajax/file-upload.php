<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 17:37
 */


//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if(empty($_POST["type"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1,2));

$return = array(
    "error" => true,
    "message" => ""
);

try {

    $PDO->beginTransaction();

    $userData = $PDO->query("SELECT 
                          phpauth_users.`id`,
                          phpauth_users.`auth`,
                          phpauth_users.`name`,
                          phpauth_users.`surname`,
                          phpauth_users.`telephone`,
                          phpauth_users.`email`,
                          phpauth_users.`country`,
                          phpauth_users.`is_individual`,
                          phpauth_users.`school_id`,
                          phpauth_users.`country_id`,
                          phpauth_users.`committee_id` ,
                          phpauth_users.`dt`,
                          schools.id as advisor_school,
                          schools.school_name,
                          countries.country_name,
                          countries.flag,
                          committee_name
                          FROM 
                          `phpauth_users` 
                          LEFT JOIN
                          `schools`
                          ON
                          schools.advisor_id = phpauth_users.id
                          OR 
                          schools.id = phpauth_users.school_id
                          LEFT JOIN 
                          `countries`
                          ON 
                          countries.id = phpauth_users.country_id
                          LEFT JOIN 
                          `committees`
                          ON 
                          committees.id = phpauth_users.committee_id
                          
                          WHERE phpauth_users.id = 
                          '".$auth->getCurrentUID()."';")->fetch(PDO::FETCH_ASSOC) ;



       //CHECK FILE
       $file_name = $_FILES["file"]["name"];
       $file_type = $_FILES["file"]["type"];
       $file_size = $_FILES["file"]["size"];
       $file_tmp = $_FILES["file"]["tmp_name"];
       $version = time();

       if(!in_array($file_type,$file_types)){
           $return = array(
               "error" => true,
               "message" => "This file type is not supported."
           );
           $PDO->rollBack();
           return_error($return);
       }


       if($file_size > 1024 * 1024 * 10 /*10MB*/){
           $return = array(
               "error" => true,
               "message" => "File is larger than 10 MB."
           );
           $PDO->rollBack();
           return_error($return);
       }



       if(!is_dir(files_directory)){

           $return = array(
               "error" => true,
               "message" => "Upload Directory Is Invalid."
           );
           $PDO->rollBack();
           return_error($return);

       }

    if( post("type") =="first_commit" && is_authorized($userData["auth"],array(2)) ){

        $split = pathinfo(sanitizeFileName($file_name));
        $upload_name = $split["filename"]."-".$version.".".$split["extension"];

        $unq_id = uniqid();

        $prep = $PDO->prepare(
            "INSERT 
                      INTO 
                      `files`
                      SET 
                      unq_id = :unq_id,
                      file_version = :file_version,
                      file_name = :file_name,
                      root_name = :root_name,
                      file_size = :file_size,
                      committer_id = :committer_id,
                      country_id = :country_id,
                      committee_id = :committee_id,
                      file_type = :file_type,
                      status = 0
                      ");

        $exec = $prep -> execute(array(
            "unq_id" => $unq_id,
            "file_version" => $version,
            "file_name" => $upload_name,
            "root_name" => $file_name,
            "file_size" => $file_size,
            "file_type" => $file_type,
            "committer_id" => $userData["id"],
            "country_id" => post("country_id"),
            "committee_id" => post("committee_id")
        ));

        $return = array(
            "error" => false,
            "message" => "File Succesfully Uploaded"
        );

    }else if(post("type") =="file_recommit" && is_authorized($userData["auth"],array(2) )){

        $file_data = $PDO->query("SELECT * FROM `files` WHERE unq_id = '{$_POST["unique_id"]}' ORDER BY file_version ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

        $split = pathinfo(sanitizeFileName($file_data["root_name"]));
        $upload_name = $split["filename"]."-".$version.".".pathinfo($file_name)["extension"];

        $prep = $PDO->prepare(
            "INSERT 
                      INTO 
                      `files`
                      SET 
                      unq_id = :unq_id,
                      file_version = :file_version,
                      file_name = :file_name,
                      root_name = :root_name,
                      file_size = :file_size,
                      committer_id = :committer_id,
                      country_id = :country_id,
                      committee_id = :committee_id,
                      file_type = :file_type,
                      status = 0
                      ");

        $exec = $prep -> execute(array(
            "unq_id" => $file_data["unq_id"],
            "file_version" => $version,
            "file_name" => $upload_name,
            "root_name" => $file_data["root_name"],
            "file_size" => $file_size,
            "file_type" => $file_type,
            "committer_id" => $auth->getCurrentUID(),
            "country_id" => $file_data["country_id"],
            "committee_id" => $file_data["committee_id"]
        ));

        $return = array(
            "error" => false,
            "message" => "File Succesfully Uploaded"
        );

        }
    else{
        $return = array(
            "error" => true,
            "message" => "No Type Provided."
        );
        $PDO->rollBack();
        return_error($return);
    }



    //UPLOAD FILE
    if (!move_uploaded_file($file_tmp,files_directory."/".$upload_name  )) {

        $return = array(
            "error" => true,
            "message" => "File Could Not Be Uploaded."
        );
        $PDO->rollBack();
        return_error($return);

    }


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