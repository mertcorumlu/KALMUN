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
                        <small class="text-danger">Files listed for commitee <?=$userData["committee_name"]?></small>
                        <br>
                        <br>
                        <table class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>Unique ID</th>
                                <th>File</th>
                                <th>Submitted By</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            try{

                                /*
                                 * SELECT ALL COMMITTEES
                                 * JOIN THEM WITH ADVISOR NAME AND COUNTRY NAME
                                 */
                                $files = $PDO->query("
                                        SELECT
                                          files.id as file_id,
                                          files.file_name,
                                          files.unq_id,
                                          files.file_type,
                                          files.status,
                                          files.is_reso,
                                          phpauth_users.name,
                                          phpauth_users.surname,
                                          phpauth_users.auth,
                                          committees.committee_name,
                                          countries.country_name,
                                          countries.flag
                                        
                                        FROM
                                          `files`
                                          LEFT JOIN
                                          `phpauth_users`
                                            ON
                                              phpauth_users.id = files.committer_id
                                          LEFT JOIN
                                          `committees`
                                            ON
                                              committees.id = files.committee_id
                                          LEFT JOIN
                                          `countries`
                                            ON
                                              countries.id = files.country_id
                                        WHERE
                                          files.date  IN(SELECT MAX(files.date) FROM files GROUP BY files.unq_id)
                                          AND 
                                          files.committee_id = {$userData["committee_id"]}
                                ");

                                /*
                                 * DISPLAY ALL SCHOOLS
                                 */
                                while($data = $files->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><strong><?=$data["unq_id"]?></strong></td>
                                        <td>
                                            <i class="fa
                                            <?php
                                            switch($data["file_type"]){
                                                case "application/pdf":
                                                    echo "fa-file-pdf-o";
                                                    break;

                                                case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                                                case "application/msword":
                                                    echo "fa-file-word-o";
                                                    break;
                                            }
                                            ?>
                                            "></i>

                                            <a href="/get_file?id=<?=$data["file_id"]?>"><?=$data["file_name"]?></a>

                                        </td>
                                        <td>
                                            <strong>

                                                (<?php
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
                                                ?>)
                                            </strong>
                                            <?=$data["name"]." ".$data["surname"]?></td>
                                        <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div> <?=$data["country_name"]?></td>
                                        <td><?=$file_status_button[$data["status"]]?>
                                            <?=($data["is_reso"] == "1" ? "<i class=\"fa fa-star text-warning ambassador\" data-toggle=\"tooltip\" title=\"Plenary Session Resolution\" ></i>" : "")?>
                                        </td>
                                        <td><button class="btn btn-primary" onclick="open_popup('/inc/ajax/file-view-versions?unique_id=<?=$data["unq_id"]?>')">View Versions</button></td>
                                        <td>
                                            <?php
                                            if($data["status"] == "1"){
                                                ?>
                                                <button class="btn btn-primary" onclick="open_popup('/inc/ajax/file-recommit-chair?unique_id=<?=$data["unq_id"]?>')">Recommit</button>
                                            <?php
                                            }else if($data["status"] == "0") {
                                                ?>

                                                <?php
                                            }else if($data["status"] == "4") {
                                                ?>
                                                <button class="btn btn-primary" onclick="open_popup('/inc/ajax/file-final-commit?unique_id=<?=$data["unq_id"]?>')">Final Commit</button>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="text-success"><strong>Resubmitted</strong></span>

                                                <?php
                                            }
                                            ?>
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
                    "order":[[1,"asc"]]
                });
            } );
        </script>

    </div>
</main>


