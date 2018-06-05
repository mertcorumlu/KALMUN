<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */

//INCLUDE THE ACTION OF SCHOOLS
switch (get("subpage")){

    case  "list":
        include 'sessions/list.php';
        break;

    case "add":
        include 'sessions/add.php';
        break;

    default:
        include 'sessions/list.php';
        break;
}
?>