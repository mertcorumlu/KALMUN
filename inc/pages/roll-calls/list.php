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
                        <table class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th>Session Name</th>
                                <th>Session Start</th>
                                <th>Session End</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            try{

                                /*
                                 * SELECT ALL SESSIONS
                                 */
                                $sessions = $PDO->query("SELECT 
                                                                      *
                                                                       FROM 
                                                                       `sessions` 
                                                                        ");



                                /*
                                 * DISPLAY ALL SESSIONS
                                 */
                                while($data = $sessions->fetch(PDO::FETCH_ASSOC)){


                                    ?>

                                    <tr>
                                        <td><?=$data["session_name"]?></td>
                                        <td><?=date('d/m/Y H:i ',strtotime($data["session_start"]))?></td>
                                        <td><?=date('d/m/Y H:i ',strtotime($data["session_end"]))?></td>

                                        <td>
                                            <?php
                                            if( strtotime($data["session_start"]) > time() ) {

                                                if ( (strtotime($data["session_start"]) - time()) < 60*60 /*1 HOUR*/ ) {

                                                    ?>
                                                    <div class="text-danger counter" data-seconds="<?=(strtotime($data["session_start"]) - time())?>"><strong></strong></div>

                                                    <?php
                                                } else {
                                                ?>
                                                <div class="text-danger"><strong>Has Not Started Yet</strong></div>
                                                <?php
                                                }

                                            }else{
                                            ?>
                                            <button type="button" class="btn btn-primary" onclick="open_popup('/inc/ajax/make-roll-call?session_id=<?=$data["id"]?>')">Roll Call</button>
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

            $("div.counter").each(function (index,data) {
                var time = $(this).data("seconds");
                var object = $(this);
                object.find("strong").html(time_to_string(time) + "Left" );
                setInterval(function () {
                    if(time === 0){
                        location.reload();
                        return;
                    }
                    time--;
                    object.find("strong").html(time_to_string(time) + "Left");
                },1000);

            });

            function time_to_string(time){
                var string="";
                var minutes = number_format(Math.floor((time % 3600) / 60));
                if(minutes > 0){
                    string += minutes+ " Minute "
                }
                var seconds = number_format(Math.floor((time % 60)));
                string += seconds+ " Second ";
                return string;
            }

            function number_format(n){
                return n > 9 ? "" + n: "0" + n;
            }


        </script>

    </div>
</main>


