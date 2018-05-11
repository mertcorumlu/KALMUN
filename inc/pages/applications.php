
<!-- ### $App Screen Content ### -->
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Applications</h4>
                        <style>
                            .static-applications  td{
                                padding: 0 !important;
                            }

                            .static-applications tbody > tr > td:first-child{
                                padding-left:10px !important;
                                vertical-align: middle;
                            }
                            .static-applications tr{
                                height:20px;
                            }
                            .static-applications .alert{
                                margin:0;
                                padding:10px;
                                border:0;
                                border-radius:0;
                            }

                            tr,td{
                                vert-align: middle;
                            }

                        </style>
                        <table class="table table-striped table-bordered dataTable no-footer static-applications" cellspacing="5" cellpadding="0">
                            <thead>
                            </thead>
                            <tbody>
                            <?php

                            try{

                                //SELECT COUNT OF ALL APPLICATIONS
                                $query = $PDO->query("SELECT 
                                                              COUNT(`id`) AS `counts`,`type`,`status` 
                                                              FROM 
                                                              `applications` 
                                                              Group BY 
                                                              `type`,`status` 
                                                              ORDER BY 
                                                              `type` 
                                                              ASC
                                                              ");

                                /*
                                 * COUNT ALL APPLICATIONS FOR EACH APPLICATION TYPE
                                 * USE $countArray defined in config.php
                                 */
                                while($data = $query->fetch(PDO::FETCH_ASSOC)){

                                    $countArray[$data["type"]][$data["status"]] += (int) $data["counts"];

                                }

                                //PRINT ALL APPLICATION TYPES
                                //USE $Application_Type variable from config.php
                                for($i=1;$i <= 4 ;$i++){
                            ?>

                            <tr>
                                <td><strong><?=$Application_Type[$i]?></strong></td>
                                <td><div class="alert alert-warning text-center"><?=$countArray[$i][0]?> Pending</div></td>
                                <td><div class="alert alert-success text-center"><?=$countArray[$i][1]?> Approved</div></td>
                                <td><div class="alert alert-danger text-center"><?=$countArray[$i][2]?> Rejected</div></td>
                            </tr>
                            <?php
                                }
                            }catch (PDOException $e){
                                trigger_error($e->errorInfo[2],E_USER_ERROR);
                            }
                            ?>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td style="text-align: right;padding-right:10px !important;"><strong>Total</strong></td>
                                <td><div class="alert alert-warning text-center"><?=$countArray[1][0]+$countArray[2][0]+$countArray[3][0]+$countArray[4][0]?> Pending</div></td>
                                <td><div class="alert alert-success text-center"><?=$countArray[1][1]+$countArray[2][1]+$countArray[3][1]+$countArray[4][1]?> Approved</div></td>
                                <td><div class="alert alert-danger text-center"><?=$countArray[1][2]+$countArray[2][2]+$countArray[3][2]+$countArray[4][2]?> Rejected</div></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <table class="DataTable table table-striped table-bordered dataTable no-footer" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Full Name</th>
                                <th>School</th>
                                <th>Country</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Application Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            try{
                                //SELECT ALL APPLICATIONS
                                $applications = $PDO->query("SELECT * FROM `applications` ORDER BY `date` DESC");
                                while($data = $applications->fetch(PDO::FETCH_ASSOC)){


                            ?>

                                <tr>
                                    <td><strong><?=$Application_Type[$data["type"]]?></strong></td>
                                    <td><?=sprintf($Application_Status_Button[$data["status"]],$data["id"])?></td>
                                    <td><?=$data["name"]." ".$data["last_name"]?></td>
                                    <td><?=$data["school"]?></td>
                                    <td><div class="flag flag-<?=mb_strtolower($data["country"])?>" style="vertical-align:middle"></div> <span><?=$data["country"]?></span></td>
                                    <td><?=$data["email"]?></td>
                                    <td><?=$data["telephone"]?></td>
                                    <td><?=$data["date"]?></td>

                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/application-data?id=<?=$data["id"]?>')"><?php echo $data["status"] == 1 ? "View" : "Evaluate" ?></button>
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
                    "order":[[7,"desc"]]
                });
            } );
        </script>

    </div>
</main>

