<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 13/05/2018
 * Time: 20:01
 */

//LOAD APP
include "loader.php";

date_default_timezone_set("Europe/Istanbul");

try{

    //CONTROL IF ADVISOR HAS CREATED ANY USER
    $userData = $PDO->query("SELECT 
                          phpauth_users.`id`,
                          phpauth_users.`auth`,
                          phpauth_users.`name`,
                          phpauth_users.`surname`,
                          phpauth_users.`telephone`,
                          phpauth_users.`email`,
                          phpauth_users.`country`,
                          phpauth_users.`is_individual`,
                          phpauth_users.`school_id`,
                          phpauth_users.`country_id`,
                          phpauth_users.`committee_id` ,
                          phpauth_users.`dt`,
                          schools.id as advisor_school,
                          schools.school_name,
                          countries.country_name,
                          countries.flag,
                          committee_name
                          FROM 
                          `phpauth_users` 
                          LEFT JOIN
                          `schools`
                          ON
                          schools.advisor_id = phpauth_users.id
                          OR 
                          schools.id = phpauth_users.school_id
                          LEFT JOIN 
                          `countries`
                          ON 
                          countries.id = phpauth_users.country_id
                          LEFT JOIN 
                          `committees`
                          ON 
                          committees.id = phpauth_users.committee_id
                          
                          WHERE phpauth_users.id = 
                          '".$auth->getCurrentUID()."';")->fetch(PDO::FETCH_ASSOC) ;


                    if(!defined("auth_level"))
                        define("auth_level",$userData["auth"]);


          //REDIREVT ADVISORS IF NOT YET SET THEIR DELEGATES
          if(auth_level == "3"){

              if(
                  $PDO->query("SELECT
                                    `id` 
                                    FROM 
                                    `schools`
                                  WHERE
                                    `advisor_id` = '".$userData["id"]."';")->rowCount() < 1 ){

                  if(@$_GET["page"] != "notactiveted" ){
                      include'pages/notactivated.php';
                      exit;
                  }

              }

              if(
              $PDO->query("SELECT
                                    `id` 
                                    FROM 
                                    `phpauth_users`
                                  WHERE
                                    `school_id` = '".$userData["advisor_school"]."'")->rowCount()

                                        <

              $PDO->query("SELECT
                                    SUM(quota) as toplam
                                    FROM 
                                    `committee_structure`
                                  WHERE
                                    `school_id` = '".$userData["advisor_school"]."'")->fetch(PDO::FETCH_ASSOC)["toplam"]
              ){
										
									

                  if( !(@$_GET["page"] == "student" && (@$_GET["subpage"] == "add"|| @$_GET["subpage"] =="list") )  ){
                      echo '<script>location.replace("/student/add")</script>';
                      exit;
                  }

              }





          }




              include 'pages.php';

}catch (PDOException $e){
   trigger_error($e->getMessage());
    exit;
}


