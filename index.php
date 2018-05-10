<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:04
 */

include "inc/loader.php";


$include_page = "";
$auth_levels = array();
$head = "";
$footer = "";


switch(get("page")){

    case "":
        $include_page = "home";
        $auth_levels = array(1,2,3,4);
        break;

    case "home":
        $include_page = "home";
        $auth_levels = array(1,2,3,4);
        break;

    case "applications":
        $include_page = "applications";
        $head = "<link rel=\"stylesheet\" href=\"/inc/css/popup.css\"/>";
        $footer = "<script src=\"/inc/js/popup.js\"></script>\n<script src=\"/inc/js/applications.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "school":
        $include_page = "school";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
<link rel='stylesheet' href='/inc/css/popup.css'>";
        $footer = "'<script src=\"/inc/js/popup.js\"></script>'";
        $auth_levels = array(0,1);
        break;

    case "login":
        $include_page = "login";
            if($auth->isLogged()){
                redirect("/");
            }
            include("inc/pages/".$include_page.".php");
            exit;
            break;

    case "registration":
        $include_page = "registration";
        if($auth->isLogged()){
            redirect("/");
            }
        include("inc/pages/".$include_page.".php");
        exit;
        break;

    default:
        $include_page = "404";
        include("inc/pages/".$include_page.".php");
        exit;
        break;

}

if(!empty($auth_levels)){
    check_login($PDO,$auth,$auth_levels);
}

include("inc/static/head.php");

include("inc/pages/".$include_page.".php");

include("inc/static/footer.php");

?>
