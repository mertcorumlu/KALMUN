<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 17:06
 */


//if(auth_level == "2"){

    //INCLUDE THE ACTION OF roll-calls
    switch (get("subpage")){

        case  "list":
            include 'roll-calls/list.php';
            break;

//        case "add":
//            include 'roll-calls/add.php';
//            break;

        default:
            include 'roll-calls/list.php';
            break;
    }

//}else if(auth_level == "0" || auth_level == "1") {
//    include 'roll-calls/moderator.php';
//}

?>