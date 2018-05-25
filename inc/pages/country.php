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
        include 'country/list.php';
        break;

    case "add":
        include 'country/add.php';
        break;

    default:
        include 'country/list.php';
        break;
}
?>