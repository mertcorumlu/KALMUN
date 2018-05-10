<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:17
 */


session_start();
require( "config.php" );

//Class load
include("PHPAuth/Auth.php");
include("PHPAuth/Config.php");
require("ZxcvbnPhp/Matchers/MatchInterface.php");
require("ZxcvbnPhp/Matchers/Match.php");
require("ZxcvbnPhp/Matchers/DigitMatch.php");
require("ZxcvbnPhp/Matchers/Bruteforce.php");
require("ZxcvbnPhp/Matchers/YearMatch.php");
require("ZxcvbnPhp/Matchers/SpatialMatch.php");
require("ZxcvbnPhp/Matchers/SequenceMatch.php");
require("ZxcvbnPhp/Matchers/RepeatMatch.php");
require("ZxcvbnPhp/Matchers/DictionaryMatch.php");
require("ZxcvbnPhp/Matchers/L33tMatch.php");
require("ZxcvbnPhp/Matchers/DateMatch.php");
require("ZxcvbnPhp/Matcher.php");
require("ZxcvbnPhp/Searcher.php");
require("ZxcvbnPhp/ScorerInterface.php");
require("ZxcvbnPhp/Scorer.php");
require("ZxcvbnPhp/Zxcvbn.php");
include("PHPMailer/src/PHPMailer.php");
include("PHPMailer/src/Exception.php");
include("PHPMailer/src/SMTP.php");
include("PHPMailer/src/OAuth.php");
include("PHPMailer/src/POP3.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//SQL Connection
$PDO="";
try{
    $PDO = new PDO("mysql:host={$db_host};dbname={$db_name};charset=UTF8",$db_user,$db_password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die("Database Connection Failed.");
}



//Php Auth Class
$auth_config = "";
$auth = "";

try{
    $auth_config = new PHPAuth\Config($PDO);
    $auth   = new PHPAuth\Auth($PDO, $auth_config);
}catch (Exception $e) {
    die("Class Import Error On Loader.");
}

//Phpmailer
$phpmailer = new PHPMailer();
//$phpmailer->isSMTP();
//$phpmailer->SMTPDebug = 4;
//$phpmailer->Host = 'localhost'; // duzenlenecek
//$phpmailer->SMTPAuth = true;
//$phpmailer->Username = 'info@kalthefest.org'; // duzenlenecek
//$phpmailer->Password = 'TaTar5544'; // duzenlenecek
//$phpmailer->SMTPSecure = 'tls'; // duzenlenecek
//$phpmailer->Port = 587; // duzenlenecek
$phpmailer->From = 'info@kalthefest.org'; // duzenlenecek
$phpmailer->FromName = 'KAL Model Unites Nations'; // duzenlenecek
$phpmailer->AddReplyTo("info@kalmun.org");


include ( "functions.php" );


