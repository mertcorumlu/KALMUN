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
        include 'committee/list.php';
        break;

    case "add":
        include 'committee/add.php';
        break;

    default:
        include 'committee/list.php';
        break;
}
?>