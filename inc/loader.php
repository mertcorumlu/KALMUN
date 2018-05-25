<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:17
 */

//session start for cookies
session_start();

//Load Config
require( "config.php" );

//Load Classes
include("classes/PHPAuth/Auth.php");
include("classes/PHPAuth/Config.php");
require("classes/ZxcvbnPhp/Matchers/MatchInterface.php");
require("classes/ZxcvbnPhp/Matchers/Match.php");
require("classes/ZxcvbnPhp/Matchers/DigitMatch.php");
require("classes/ZxcvbnPhp/Matchers/Bruteforce.php");
require("classes/ZxcvbnPhp/Matchers/YearMatch.php");
require("classes/ZxcvbnPhp/Matchers/SpatialMatch.php");
require("classes/ZxcvbnPhp/Matchers/SequenceMatch.php");
require("classes/ZxcvbnPhp/Matchers/RepeatMatch.php");
require("classes/ZxcvbnPhp/Matchers/DictionaryMatch.php");
require("classes/ZxcvbnPhp/Matchers/L33tMatch.php");
require("classes/ZxcvbnPhp/Matchers/DateMatch.php");
require("classes/ZxcvbnPhp/Matcher.php");
require("classes/ZxcvbnPhp/Searcher.php");
require("classes/ZxcvbnPhp/ScorerInterface.php");
require("classes/ZxcvbnPhp/Scorer.php");
require("classes/ZxcvbnPhp/Zxcvbn.php");
include("classes/PHPMailer/src/PHPMailer.php");
include("classes/PHPMailer/src/Exception.php");
include("classes/PHPMailer/src/SMTP.php");
include("classes/PHPMailer/src/OAuth.php");
include("classes/PHPMailer/src/POP3.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//SQL Connection
$PDO="";
try{
    $PDO = new PDO("mysql:host={$db_host};dbname={$db_name};charset=UTF8",$db_user,$db_password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    http_response_code(500);
    die("<h1>Database Connection Failed.</h1>");
}



//Php Auth Class
$auth_config = "";
$auth = "";
try{
    $auth_config = new PHPAuth\Config($PDO);
    $auth   = new PHPAuth\Auth($PDO, $auth_config);
}catch (Exception $e) {
    http_response_code(500);
    die("Class Import Error On Loader.");
}

//Load PHPMailer
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
//$phpmailer->SMTPDebug = 0;
//$phpmailer->SMTPSecure = false;
//$phpmailer -> SMTPAutoTLS = false;
//$phpmailer->Host = "mail.kalmun.org";
//$phpmailer->SMTPAuth = true;
//$phpmailer->Username = 'noreply@kalmun.org'; // duzenlenecek
//$phpmailer->Password = 'WJza46H2'; // duzenlenecek
////$phpmailer->SMTPSecure = 'tls'; // duzenlenecek
//$phpmailer->Port = 587; // duzenlenecek
$phpmailer->From = 'noreply@kalmun.org'; // duzenlenecek
$phpmailer->FromName = 'KAL Model United Nations'; // duzenlenecek
$phpmailer->AddReplyTo("info@kalmun.org");



//Include functions
include ( "functions.php" );


