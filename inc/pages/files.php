<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 17:06
 */


if(auth_level == "2"){

    //INCLUDE THE ACTION OF FILES
    switch (get("subpage")){

        case  "list":
            include 'files/list.php';
            break;

        case "add":
            include 'files/add.php';
            break;

        case "plenary-session-resolution":

            if( $userData["committee_id"] == $auth->config->ga1_id ||
                $userData["committee_id"] == $auth->config->ga3_id ||
                $userData["committee_id"] == $auth->config->ga4_id ||
                $userData["committee_id"] == $auth->config->ga6_id ){
                include 'files/plenary-session-resolution.php';
            }else{
                include 'unauthorized.php';
            }

            break;

        default:
            include 'files/list.php';
            break;
    }

}else if(auth_level == "0" || auth_level == "1") {
    include 'files/moderator.php';
}

?>