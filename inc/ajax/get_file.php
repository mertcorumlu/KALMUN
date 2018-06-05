<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 21:29
 */

//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if( empty($_GET["id"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1,2,3,4));

try{

    $data = $PDO->query("
    SELECT
    *
    FROM
    `files`
    WHERE
    id={$_GET["id"]}
    ");

    if($data->rowCount() < 1){
        include("../");
        exit;
    }
    $data = $data->fetch(PDO::FETCH_ASSOC);

    if(!file_exists(files_directory."/".$data["file_name"])){
        echo 'No such file!';
        exit;
    }

    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Disposition: attachment; filename=\"" . $data["file_name"]);
    readfile(files_directory."/".$data["file_name"]);



}catch (PDOException $e){
    echo $e->getMessage();
    exit;
}