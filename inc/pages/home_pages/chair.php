<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 31/05/2018
 * Time: 12:39
 */

try{

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
                                          AND 
                                          (
                                          files.`status` = 1 
                                          OR 
                                          files.`status` = 4
                                          )
                                ");

    $date = date("Y-m-d\TH:i",time());

    $session = $PDO->query("
    SELECT
    *
    FROM
    `sessions`
    WHERE
    sessions.session_end > '{$date}'
    ORDER BY 
    session_start
    ASC 
    LIMIT
    1
    
    ");

    $users = $PDO->query("
                                            SELECT 
                                            countries.id AS `country_id`,
                                            countries.country_name,
                                            countries.flag,
                                            phpauth_users.name,
                                            phpauth_users.surname
                                            FROM 
                                            `phpauth_users` 
                                            INNER JOIN 
                                            `countries` 
                                            ON 
                                            phpauth_users.country_id = countries.id 
                                            WHERE 
                                            `committee_id` = '{$userData["committee_id"]}'
                                            AND 
                                            `auth` = 4 "
    );


    ?>
    <div class="row gap-20 masonry pos-r">

        <div class="masonry-ite col-12">
            <div class="bd bgc-white p-20">
                <p>
                <h2>Welcome to K@LMUN !</h2>

                <p>K@LMUN is a system that allows our team to multitask most of the MUN requirements and facilities.</p>
                </p>
            </div>

        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Next Session</h6>
                            </div>
                            <div class="layer w-100">
                                <div id="world-map-marker">

                                    <?php
                                    if($session->rowCount() < 1){
                                        ?>
                                        <div class="alert alert-warning">No Session Found</div>
                                        <?php
                                    }else {

                                        ?>
                                        <table id="sessions" class="DataTable chair-table table  dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">

                                        <thead>
                                            <tr>
                                                <th data-priority="1">Session Name</th>
                                                <th >Session Start</th>
                                                <th>Session End</th>
                                                <th data-priority="2"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            while ($data = $session->fetch(PDO::FETCH_ASSOC)) {


                                                ?>

                                                <tr>
                                                    <td><strong><?= $data["session_name"] ?></strong></td>
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


                                            ?>


                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->

            <div class="bd bgc-white">
                <div class="fxw-nw@lg+ ">
                    <div class="peer peer-greed p-20">

                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Your Pending Files</h6>
                            </div>

                            <div class="layer w-100">
                                <div class="row">

                                    <?php
                                    if($files->rowCount() < 1){
                                        ?>
                                        <div class="alert alert-warning">You Have No Pending Files</div>
                                        <?php
                                    }else {

                                        ?>
                                        <table id="files" class="DataTable chair-table table dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                                            <thead>
                                            <tr>
                                                <th >Unique ID</th>
                                                <th data-priority="1">File Name</th>
                                                <th >Submitted By</th>
                                                <th >Country</th>
                                                <th data-priority="2">Status</th>
                                                <th data-priority="3"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            while ($data = $files->fetch(PDO::FETCH_ASSOC)) {


                                                ?>

                                                <tr>
                                                    <td><strong><?= $data["unq_id"] ?></strong></td>
                                                    <td>
                                                        <i class="fa
                                            <?php
                                                        switch ($data["file_type"]) {
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

                                                        <a href="/get_file?id=<?= $data["file_id"] ?>"><?= $data["file_name"] ?></a>

                                                    </td>
                                                    <td>
                                                        <strong>

                                                            (<?php
                                                            switch ($data["auth"]) {

                                                                case 0;
                                                                    echo '<span class="text-secondary">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 1;
                                                                    echo '<span class="text-danger">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 2;
                                                                    echo '<span class="text-success">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 3;
                                                                    echo '<span class="text-warning">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 4;
                                                                    echo '<span class="text-primary">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;


                                                            }
                                                            ?>)
                                                        </strong>
                                                        <?= $data["name"] . " " . $data["surname"] ?></td>
                                                    <td>
                                                        <div
                                                                class=" <?= $data["flag"] != "" ? "flag flag-" . strtolower($data["flag"]) : "" ?>"
                                                                style="vertical-align: middle"></div> <?= $data["country_name"] ?>
                                                    </td>
                                                    <td><?= $file_status_button[$data["status"]] ?>
                                                        <?= ($data["is_reso"] == "1" ? "<i class=\"fa fa-star text-warning ambassador\" data-toggle=\"tooltip\" title=\"Plenary Session Resolution\" ></i>" : "") ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                                onclick="location.replace('/files/list')">Go To Files
                                                        </button>
                                                    </td>

                                                </tr>

                                                <?php
                                            }


                                            ?>


                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="peers fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Your Committee</h6>
                            </div>
                            <div class="layer w-100">
                                <div id="world-map-marker">

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Country</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while($users_fetch = $users->fetch(PDO::FETCH_ASSOC)){

                                            ?>

                                            <tr>
                                                <td>
                                                    <?=$users_fetch["name"]." ".$users_fetch["name"]?>
                                                </td>


                                                <td>
                                                    <div class=" <?=$users_fetch["flag"] != "" ? "flag flag-".strtolower($users_fetch["flag"]) :"" ?>" style="vertical-align: middle"></div>
                                                    <?=$users_fetch["country_name"]?>
                                                </td>

                                            </tr>

                                            <?php
                                        }
                                        ?>



                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready( function () {
            $('#files').DataTable({
                "bPaginate": false,
                bFilter: false,
                bInfo: false,
                responsive: true

            });
            $('#sessions').DataTable({
                "bPaginate": false,
                bFilter: false,
                bInfo: false,
                responsive: true

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

    <?php
}catch(PDOException $e){
    return_error($e->getMessage());
}
