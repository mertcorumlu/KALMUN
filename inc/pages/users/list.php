<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */
try{
    $count_users = $PDO->query("SELECT COUNT(id) as 'count',isactive FROM phpauth_users WHERE isactive = 0")
        ->fetch(PDO::FETCH_ASSOC);


?>

<!-- ### $App Screen Content ### -->
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <?php
            if($count_users["count"] > 0){


            ?>
            <div class="row">

                <div class="col-md-12" style="padding:0;">

                   <div class="alert alert-danger text-center"><?=$count_users["count"]?> User Waiting For Activation</div>


                </div>


            </div>

            <?php
            }
            ?>




            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <style>
                            .DataTable tr,td{
                                vertical-align: middle;
                            }
                        </style>
                        <table class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                            <thead>

                            <tr>
                                <th>ID</th>
                                <th>Active</th>
                                <th>Full Name</th>
                                <th>School</th>
                                <th>Statue</th>
                                <th>E-mail</th>
                                <th>Telephone</th>
                                <th>Representing Country</th>
                                <th>Committee</th>
                                <th>Action</th>
                                <th></th>

                            </tr>

                            </thead>
                            <tbody>

                            <?php


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
                                                                      schools.advisor_id = phpauth_users.id OR schools.id = phpauth_users.school_id
                                                                      
                                                                    LEFT JOIN
                                                                      `countries`
                                                                    ON
                                                                      countries.id = phpauth_users.country_id
                                                                    
                                                                        ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><strong><?=$data["id"]?></strong></td>
                                        <td><?php echo $data["isactive"] == 1 ? "Yes" : "<span class=\"text-danger\" >No</span> " ?></td>
                                        <td><?=$data["name"]?></td>
                                        <td><?=$data["school_name"]?></td>
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
                                        <td><?=$data["email"]?></td>
                                        <td><?=$data["telephone"]?></td>
                                        <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div><?=$data["country_name"]?></td>
                                        <td><?=$data["committee_name"]?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/user-edit?id=<?=$data["id"]?>')">Edit</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger delete-button" data-type="user" data-id="<?=$data["id"]?>" >Delete</button>
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
                    "order":[[0,"asc"]]
                });
            } );
        </script>

    </div>
</main>


