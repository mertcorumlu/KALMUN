<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 17:37
 */


//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if( empty($_GET["unique_id"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1,2,4));

$return = array(
    "error" => true,
    "message" => ""
);

try {

    $files = $PDO->query("
                                        SELECT
                                          files.id as file_id,
                                          files.file_name,
                                          files.unq_id,
                                          files.file_type,
                                          files.file_version,
                                          files.status,
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
                                          files.unq_id = '{$_GET["unique_id"]}'
                                          ORDER BY file_version ASC
                                        
                                ");

    if($files->rowCount() < 1){
        echo 'No Such File!';
    }

    ?>

    <div class="container-fluid" style="padding:0;">
        <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
        <div class="row">

            <div class="col-md-12" style="padding:0;">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mT-10 mB-30">File Versions</h4>
                    <small>File Unique ID : <?=$_GET["unique_id"]?></small>
                    <br>
                    <br>
                    <table class="table table-file-versions table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Version</th>
                            <th>File</th>
                            <th>Submitted By</th>
                            <th>Committee</th>
                            <th>Country</th>
                            <th>Status</th>
                            <?php
                            if(auth_level == 0 || auth_level == 1) {

                                ?>
                                <th></th>
                                <?php
                            }
                                ?>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($data = $files->fetch(PDO::FETCH_ASSOC)){

                            ?>

                            <tr>
                                <td><strong><?=$data["file_id"]?></strong></td>
                                <td><?=date('d-m-Y h:i:s',$data["file_version"])?></td>
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
                                <td><?=$data["committee_name"]?></td>
                                <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div> <?=$data["country_name"]?></td>
                                <td><?=$file_status_button[$data["status"]]?></td>
                                <?php
                                if(auth_level == 0 || auth_level == 1){

                                ?>
                                <td>
                                    <button type="button" class="btn btn-danger delete-button" data-type="file-version" data-id="<?=$data["file_id"]?>" >Delete</button>
                                </td>
                                    <?php
                                }
                                    ?>
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


<?php




}catch (PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    return_error($return);
}