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
        include 'student/list.php';
        break;

    case "add":
        include 'student/add.php';
        break;

    default:
        include 'student/list.php';
        break;
}
?>