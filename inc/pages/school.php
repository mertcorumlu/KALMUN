<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */


switch (get("subpage")){

    case  "list":
        include 'school/list.php';
        break;

    case "add":
        include 'school/add.php';
        break;

    default:
        include 'school/list.php';
        break;
}
?>