<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:08
 */


$db_host = "localhost";
$db_name = "kalmun";
$db_user = "root";
$db_password = "";

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

//Applicaton types AUTHS
$Application_Auth = array(
    "1" => 3,
    "2" => 4,
    "3" => 4,
    "4" => 4
);

//APPROVED OR REJECTED
$mail_type = array(
    1 =>array(
        "subject" =>"You Application Has Been Approved.",
        "body" => "
Dear Participant,<br><br>
We have just approved your submisson.Your control panel account has been created automatically.<br>
Make sure that you account is not activated.You will get noticed with email once it gets activated.<br><br>
E-mail : <strong>%s</strong><br>
Password : <strong>%s</strong><br><br>
<p>You can change your password from system anytime you want.</p>
"
    ),
    2 =>array(
        "subject" => "You Application Has Been Rejected.",
        "body" => "
Dear Participant,<br><br>
Unfurtunately we have rejected your submission.<br>

"
    )
);

//School Quantities
$school_structure = array(

);



