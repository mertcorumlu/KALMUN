<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:04
 */

//Page name located in /pages
$include_page = "";

//A pages accessible auth levels
$auth_levels = array();

//additional info between <head></head> tags.
$head = "";

//additional info before </body> tag.
$footer = "";


switch(get("page")){

    case "":
        $include_page = "home";
        $auth_levels = array(0,1,2,3,4);
        break;

    case "home":
        $include_page = "home";
        $auth_levels = array(0,1,2,3,4);
        break;

    case "applications":
        $title = "Applications";
        $include_page = "applications";
        $head = "<link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>\n<script src=\"/inc/js/applications.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "users":
        $title = "Users";
        $include_page = "users";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "school":
        $title = "Schools";
        $include_page = "school";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "committee":
        $title = "Committees";
        $include_page = "committee";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "country":
        $title = "Countries";
        $include_page = "country";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1);
        break;

    case "sessions":
        $title = "Sessions";
        $include_page = "sessions";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1);
        break;


    case "student":
        $title = "Students";
        $include_page = "student";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(3);
        break;

    case "files":
        $title = "Files";
        $include_page = "files";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script>
<script src=\"/inc/js/jquery.fancybox.min.js\"></script>
<script src=\"/inc/js/file.js\"></script>
<script src=\"/inc/js/jquery.form.min.js\"></script>
                    ";
        $auth_levels = array(0,1,2);
        break;

    case "profile":
        $title = "Profile";
        $include_page = "profile";
        $head = "<style>input[type=text]{text-transform: capitalize}</style>
                 <link rel=\"stylesheet\" href=\"/inc/css/jquery.fancybox.min.css\">";
        $footer = "<script src=\"/inc/js/popup.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script><script src=\"/inc/js/jquery.fancybox.min.js\"></script>";
        $auth_levels = array(0,1,2,3,4);
        break;

    case "login":
        $include_page = "login";
        if($auth->isLogged()){
            redirect("/");
        }
        include("inc/pages/".$include_page.".php");
        exit;
        break;

    /*
case "forgotpassword":
$include_page = "forgotpassword";
if($auth->isLogged()){
    redirect("/");
}
include("inc/pages/".$include_page.".php");
exit;
break;*/



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


//Check login and auth levels,if not logged in redirect /login,if not authorized redirect /unauthoried
if(!empty($auth_levels)){
    check_login($PDO,$auth,$auth_levels);
}

//include static head
include("static/head.php");

//include dynamic page located in /pages
include("pages/".$include_page.".php");

//include static footer
include("static/footer.php");


