<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */

?>

<!-- ### $App Screen Content ### -->
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <style>
                            .DataTable tr,td{
                                vertical-align: middle;
                            }
                        </style>
                        <table class="DataTable table table-striped table-bordered dataTable no-footer" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>School Name</th>
                                <th>Advisor</th>
                                <th>Country</th>
                                <th>Structure</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            try{

                                /*
                                 * SELECT ALL SCHOOLS
                                 * JOIN THEM WITH ADVISOR NAME AND COUNTRY NAME
                                 */
                                $applications = $PDO->query("SELECT 
                                                                      schools.id as school_id,
                                                                      schools.school_name,
                                                                      CONCAT(phpauth_users.name,\" \",phpauth_users.surname) AS advisor_name,
                                                                      countries.country_name,
                                                                      countries.flag
                                                                       FROM 
                                                                       `schools` 
                                                                       LEFT JOIN 
                                                                       `phpauth_users`
                                                                        ON 
                                                                        schools.advisor_id = phpauth_users.id
                                                                        LEFT JOIN
                                                                        `countries`
                                                                        ON 
                                                                        schools.country_id = countries.id
                                                                        ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><strong><?=$data["school_id"]?></strong></td>
                                        <td><?=$data["school_name"]?></td>
                                        <td><?=$data["advisor_name"]?></td>
                                        <td><div style="vertical-align: middle" class="flag flag-<?=strtolower($data["flag"])?>"></div><?=$data["country_name"]?></td>

                                        <td>
                                            <?php
                                            /*
                                             * DISPLAY A SCHOOLS DELEGATE STRUCTURE
                                             * JOINT WITH COUNTRY NAME AND COMMITTEE NAME
                                             */
                                            $structure = $PDO->query("
                                            SELECT 
                                            `committees`.committee_name,
                                            committee_structure.quota,
                                            countries.country_name
                                            FROM 
                                            `committee_structure` 
                                            INNER JOIN 
                                            `countries` 
                                            ON 
                                            committee_structure.country_id = countries.id 
                                            INNER JOIN 
                                            `committees` 
                                            ON 
                                            committee_structure.committee_id = committees.id 
                                            WHERE 
                                            `school_id` = '{$data["school_id"]}'  ");


                                            /*
                                             * DISPLAY DELEGATE STRUCTURE
                                             */
                                            while ($structure_data = $structure->fetch(PDO::FETCH_ASSOC)){

                                            echo
                                                "IN 
                                                <strong>". $structure_data["committee_name"] . "</strong> 
                                                From 
                                                <strong>".$structure_data["country_name"]."</strong>
                                                <strong>".$structure_data["quota"]."</strong> Person <br>";
                                            }
                                            ?>
                                        </td>


                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/school-edit?id=<?=$data["school_id"]?>')">Edit</button>
                                        </td>



                                    </tr>

                                    <?php
                                }
                            }catch (PDOException $e){
                                trigger_error($e->errorInfo[2],E_USER_ERROR);
                            }

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
        </div>

        <script>


            $(document).ready( function () {
                $('.DataTable').DataTable({
                    "order":[[1,"desc"]]
                });
            } );
        </script>

    </div>
</main>


