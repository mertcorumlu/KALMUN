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
if( empty($_POST["type"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(2));

$return = array(
    "error" => true,
    "message" => ""
);

try {

    $PDO->beginTransaction();


    if( post("type") =="file_final_commit" ){

        if( post("file_status") == "3"){

            $file_data = $PDO->query("SELECT * FROM `files` WHERE unq_id = '{$_POST["unique_id"]}' ORDER BY file_version DESC LIMIT 1")
                ->fetch(PDO::FETCH_ASSOC);

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
                      status = '{$_POST["file_status"]}'
                      ");

            $exec = $prep -> execute(array(
                "unq_id" => $file_data["unq_id"],
                "file_version" => $file_data["file_version"],
                "file_name" => $file_data["file_name"],
                "root_name" => $file_data["root_name"],
                "file_size" => $file_data["file_size"],
                "file_type" => $file_data["file_type"],
                "committer_id" => $auth->getCurrentUID(),
                "country_id" => $file_data["country_id"],
                "committee_id" => $file_data["committee_id"]
            ));

            $return = array(
                "error" => false,
                "message" => "File Status Succesfully Saved."
            );



        }else
        {

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
                      status = '{$_POST["file_status"]}'
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

            //UPLOAD FILE
            if (!move_uploaded_file($file_tmp,files_directory."/".$upload_name  )) {

                $return = array(
                    "error" => true,
                    "message" => "File Could Not Be Uploaded."
                );
                $PDO->rollBack();
                return_error($return);

            }

        }





    }
    else{
        $return = array(
            "error" => true,
            "message" => "No Type Provided."
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