<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 01:30
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KALMUN<?php echo @$title != "" ? " | ".@$title : "" ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="/inc/img/favicon.ico" />

    <script src="/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/inc/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/inc/css/bootstrap-formhelpers.min.css">

    <link rel="stylesheet" href="/inc/css/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/inc/css/Responsive-2.2.1/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="/inc/css/stylesheet.css"/>

    <?=$head."\n"?>
</head>
<?php
include("header.php");
?>
