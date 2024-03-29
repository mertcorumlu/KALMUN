<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:08
 */

//DATABASE INFORMATION
$db_host = "localhost";
$db_name = "kalmun";
$db_user = "root";
$db_password = "";

//ACCEPTED FILE TYPES
$file_types = array(
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/pdf'
);
//FILES DIRETORY
define("files_directory",$_SERVER["DOCUMENT_ROOT"]."/inc/files");

//AUTH STATUES
$Auth_Statues = array(
    "0" => "Super Admin",
    "1" => "Moderator",
    "2" => "Chair",
    "3" => "Advisor",
    "4" => "Delegate"
);

//Application Status
$Application_Status = array(
    0 => "Pending",
    1 => "Approved",
    2 => "Rejected",
);


//Application Status Button
$Application_Status_Button = array(
    0 => "<div data-id=\"%s\" class=\"btn btn-warning c-white\" >{$Application_Status[0]}</div>",
    1 => "<div data-id=\"%s\" class=\"btn btn-success c-white\" >{$Application_Status[1]}</div>",
    2 => "<div data-id=\"%s\" class=\"btn btn-danger c-white\" >{$Application_Status[2]}</div>"
);

$file_status = array(
    0 => "Pending For Moderator",/*FOR MODEERATOR*/
    1=> "Pending For Chair",/*FOR CHAIR*/
    2 => "Approved",
    3 => "Rejected",
    4 => "Approved & Printed",
    5 => "Passed"
);

$file_status_button = array(
    0 => "<div data-id=\"%s\" class=\"btn btn-warning c-white\" >{$file_status[0]}</div>",
    1 => "<div data-id=\"%s\" class=\"btn btn-warning c-white\" >{$file_status[1]}</div>",
    2 => "<div data-id=\"%s\" class=\"btn btn-success c-white\" >{$file_status[2]}</div>",
    3 => "<div data-id=\"%s\" class=\"btn btn-danger c-white\" >{$file_status[3]}</div>",
    4 => "<div data-id=\"%s\" class=\"btn btn-success c-white\" >{$file_status[4]}</div>",
    5 => "<div data-id=\"%s\" class=\"btn btn-info c-white\" >{$file_status[5]}</div>",
);

//TYPE 1 = School Registration
//TYPE 2 = Individual Registration
//TYPE 3 = ICJ Registration
//TYPE 4 = Press Application
//Applicaton Types
$Application_Type = array(
    1 => "School Application",
    2 => "Individual Registration",
    3 => "ICJ Application",
    4 => "Press Member Application"
);

//APPLICATION COUNT ON LIST
$countArray = array(
    1 => array(0,0,0),
    2 => array(0,0,0),
    3 => array(0,0,0),
    4 => array(0,0,0)
);


//Applicaton types AUTHS
$Application_Auth = array(
    "1" => 3,
    "2" => 4,
    "3" => 4,
    "4" => 4
);


//Approved or rejected mail
$mail_type = array(
    1 =>array(
        "subject" =>"You Application Has Been Approved.",
        "body" => "
Dear Participant,<br><br>
We have just approved your submission. Your control panel account has been created automatically.<br>
Make sure that your account is not activated yet. You will get noticed with email once it gets activated.<br><br>
E-mail : <strong>%s</strong><br>
Password : <strong>%s</strong><br><br>
<p>You can change your password from system anytime.</p>
"
    ),
    2 =>array(
        "subject" => "You Application Has Been Rejected.",
        "body" => "
Dear Participant,<br><br>
Unfourtunately we have rejected your submission.<br>

"
    )
);

//ADD USER MAILS
$addeditSubject = "K@LMUN Panel Account";
$addEditUserMail = "
Dear Participant,<br><br>
Your control panel account is :<br>
E-mail : <strong>%s</strong><br>
Password : <strong>%s</strong><br><br>
<p>You can login via <a href='https://panel.kalmun.org/' target='_blank'>https://panel.kalmun.org/</a> .<br>
You can change your password from system anytime.</p>
";

$addEditUserMailAdvisor = "
Dear MUN-Director, 
<br><br>
You may start enrolling your delegates to the K@LMUN system. The information you share regarding your students will allow us to arrange badges and certificates. Please enroll your students very carefully and accordingly to their academic competency. We also ask you to choose one ambassador for each of the delegations we assigned you in the General Assembly. Only GA participants can be ambassadors. 
<br><br>
Your email: <strong>%s</strong><br>
Your password: <strong>%s</strong>
You can login via <a href='https://panel.kalmun.org/' target='_blank'>https://panel.kalmun.org/</a> .<br>
<br><br>
<p>Please complete this form in 5 days latest. We wish you the best at your work. </p>
Cordially,<br> 
KALMUN Secretariat
";



