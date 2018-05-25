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
                                <th>Statue</th>
                                <th>Active</th>
                                <th>Full Name</th>
                                <th>E-mail</th>
                                <th>Telephone</th>
                                <th>Representing Country</th>
                                <th>Committee</th>
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
                                                                      phpauth_users.id,
                                                                      CONCAT(
                                                                        phpauth_users.name,
                                                                        ' ',
                                                                        phpauth_users.surname
                                                                      ) AS `name`,
                                                                      phpauth_users.email,
                                                                      phpauth_users.telephone,
                                                                      phpauth_users.auth,
                                                                      phpauth_users.isactive,
                                                                      countries.country_name,
                                                                      countries.flag,
                                                                      committees.committee_name,
                                                                      schools.school_name
                                                                    FROM
                                                                      `phpauth_users`
                                                            
                                                                    LEFT JOIN
                                                                      `committees`
                                                                    ON
                                                                      committees.id = phpauth_users.committee_id
                                                                      
                                                                    LEFT JOIN
                                                                      `schools`
                                                                    ON
                                                                       schools.id = phpauth_users.school_id
                                                                      
                                                                    LEFT JOIN
                                                                      `countries`
                                                                    ON
                                                                      countries.id = phpauth_users.country_id
                                                                      WHERE
                                                                      phpauth_users.school_id = '{$userData["advisor_school"]} '
                                                                      AND 
                                                                      phpauth_users.auth = '4' ;
                                                                    
                                                                        ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>

                                        <td>
                                            <strong>
                                                <?php
                                                switch ($data["auth"]){

                                                    case 0;
                                                        echo '<span class="text-secondary">'.$Auth_Statues[$data["auth"]].'</span>';
                                                        break;

                                                    case 1;
                                                        echo '<span class="text-danger">'.$Auth_Statues[$data["auth"]].'</span>';
                                                        break;

                                                    case 2;
                                                        echo '<span class="text-success">'.$Auth_Statues[$data["auth"]].'</span>';
                                                        break;

                                                    case 3;
                                                        echo '<span class="text-warning">'.$Auth_Statues[$data["auth"]].'</span>';
                                                        break;

                                                    case 4;
                                                        echo '<span class="text-primary">'.$Auth_Statues[$data["auth"]].'</span>';
                                                        break;


                                                }
                                                ?>
                                            </strong>
                                        </td>
                                        <td><?php echo $data["isactive"] == 1 ? "Yes" : "<span class=\"text-danger\" >No</span> " ?></td>
                                        <td><?=$data["name"]?></td>
                                        <td><?=$data["email"]?></td>
                                        <td><?=$data["telephone"]?></td>
                                        <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div><?=$data["country_name"]?></td>
                                        <td><strong><?=$data["committee_name"]?></strong></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/student-edit?id=<?=$data["id"]?>')">Edit</button>
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

<!--        <script>-->
<!---->
<!---->
<!--            $(document).ready( function () {-->
<!--                $('.DataTable').DataTable({-->
<!--                    "order":[[6,"asc"]]-->
<!--                });-->
<!--            } );-->
<!--        </script>-->

    </div>
</main>


