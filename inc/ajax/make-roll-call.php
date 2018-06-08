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
if( empty($_GET["session_id"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1,2));

$return = array(
    "error" => true,
    "message" => ""
);

try {

    $users = $PDO->query("
                                        SELECT
                                      phpauth_users.id,
                                      phpauth_users.name,
                                      phpauth_users.surname,
                                      committees.committee_name,
                                      countries.country_name,
                                      countries.flag,
                                      roll_calls.status
                                    FROM
                                      `phpauth_users`
                                      LEFT JOIN
                                      `committees`
                                        ON
                                          committees.id = phpauth_users.committee_id
                                      LEFT JOIN
                                      `countries`
                                        ON
                                          countries.id = phpauth_users.country_id
                                      LEFT JOIN
                                        `roll_calls`
                                      ON
                                          roll_calls.user_id = phpauth_users.id
                                        AND
                                            roll_calls.session_id = '{$_GET["session_id"]}'
                                    
                                    WHERE
                                      phpauth_users.auth = 4
                                      AND
                                      phpauth_users.committee_id = (SELECT committee_id FROM phpauth_users WHERE id = '{$auth->getCurrentUID()}')
                                            
                                ");

    if($users->rowCount() < 1){
        echo 'No Session Found!';
        exit;
    }

    $sessionData = $PDO->query("
    SELECT
    id,
    session_name,
    session_start,
    session_end
    FROM 
    sessions
    WHERE
    id = '{$_GET["session_id"]}'
    ")->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="container-fluid" style="padding:0;">
        <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
        <div class="row">

            <div class="col-md-12" style="padding:0;">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mT-10 mB-30">Roll Call</h4>
                    <small>Session Name : <?=$sessionData["session_name"]?></small>
                    <br>
                    <small>Session Start : <?=date('d/m/Y H:i ',strtotime($sessionData["session_start"]))?></small>
                    <br>
                    <small>Session End : <?=date('d/m/Y H:i ',strtotime($sessionData["session_end"]))?></small>
                    <br>
                    <br>
                    <form id="roll_call_form" action="" method="POST"  class="needs-validation" >
                        <fieldset>
                            <table id="users" class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                                <thead>
                                <tr>
                                    <th data-priority="1">Name</th>
                                    <th>Committee</th>
                                    <th>Country</th>
                                    <th data-priority="2">Status</th>

                                </tr>
                                </thead>

                                 <tbody>


                                    <?php
                                    while($data = $users->fetch(PDO::FETCH_ASSOC)){

                                        ?>

                                        <tr>
                                            <td><strong><?=$data["name"]." ".$data["surname"]?></strong></td>
                                            <td><?=$data["committee_name"]?></td>
                                            <td><div class=" <?=$data["flag"] != "" ? "flag flag-".strtolower($data["flag"]) :"" ?>" style="vertical-align: middle"></div> <?=$data["country_name"]?></td>
                                            <td>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="user_status[<?=$data["id"]?>]" style="text-transform: " required>
                                                            <option value="">Not Taken Yet</option>
                                                            <option value="0" <?=$data["status"] == "0" ? "selected" : ""?>>Absent</option>
                                                            <option value="1" <?=$data["status"] == "1" ? "selected" : ""?>>Present</option>
                                                        </select>

                                                        <div class="invalid-feedback">
                                                            Please enter a valid session name.
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>



                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>
                                            </td>
                                        </tr>
                                    </tfoot>


                            </table>

                            <div class="alert message"></div>
                        </fieldset>
                        <input type="hidden" name="session_id" value="<?=$sessionData["id"]?>" >
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#users').DataTable({
                "bPaginate": false,
                bFilter: false,
                bInfo: false
            });
        } );

        var button = $("button[type=submit]");
        $("#roll_call_form").on("submit",function (e) {
            e.preventDefault();

            if(!$("#roll_call_form").hasClass("not-valid")){

                $.ajax({
                    type: "POST",
                    url: "/inc/ajax/make-roll-call-post",
                    data: $("#roll_call_form").serializeArray(),
                    beforeSend:function () {
                        show_loading(button);
                    },
                    error:function () {
                        $(".alert.message").addClass("alert-danger").html("An Error Occured.Please Contact Administrator.").slideDown();
                        hide_loading(button);
                    },
                    success: function (data) {
                        hide_loading(button);

                        if(data.error === true){
                            $(".alert.message").addClass("alert-danger").html(data.message +".Please Contact Administrator.").slideDown();
                            return 0;
                        }

                        $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/roll-calls/list'>List Sessions</a></div>");



                    }
                });
            }



        });

        function show_loading(a){
            $("fieldset").attr("disabled",true);
            a.data("original-text",a.html());
            a.attr("disabled", true);
            a.html(a.data("loading-text"));
        }

        function hide_loading(a){
            $("fieldset").attr("disabled",false);
            a.html("Submit");
            a.attr("disabled", false);
        }
    </script>


    <?php




}catch (PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    return_error($return);
}