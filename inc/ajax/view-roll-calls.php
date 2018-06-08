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
if( empty($_GET["id"]) ){
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


    $sessionData = $PDO->query("
    SELECT
    id,
    session_name,
    session_start,
    session_end
    FROM 
    sessions
    WHERE
    id = '{$_GET["id"]}'
    ")->fetch(PDO::FETCH_ASSOC);

    $commitee = $PDO->query("SELECT * FROM `committees`");

    ?>

    <div class="container-fluid" style="padding:0;">
        <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
        <div class="row">

            <div class="col-md-12" style="padding:0;">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mT-10 mB-30">Roll Calls</h4>
                    <small>Session Name : <?=$sessionData["session_name"]?></small>
                    <br>
                    <small>Session Start : <?=date('d/m/Y H:i ',strtotime($sessionData["session_start"]))?></small>
                    <br>
                    <small>Session End : <?=date('d/m/Y H:i ',strtotime($sessionData["session_end"]))?></small>
                    <br>
                    <br>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"><strong>Choose Committee <span class="text-danger">*</span></strong></label>
                        <div class="col-sm-6">
                            <select id="choose_committee" data-session="<?=$sessionData["id"]?>" class="form-control">
                                <option value="">Please Select...</option>
                                <?php
                                while($data = $commitee->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                    <option value="<?=$data["id"]?>"><?=$data["committee_name"]?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="roll-content">

                    </div>

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

        $(document).on("change","select#choose_committee",function () {
            var committee_id = $(this).val();
            var session_id = $(this).data("session");
            $.ajax({
                type: "GET",
                url: "/inc/ajax/get-roll-calls",
                data: {
                    "committee_id" : committee_id,
                    "session_id" : session_id
                },
                beforeSend:function () {
                    $("div.roll-content").html('<div class="loader"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                error:function () {
                    $("div.roll-content").html('<div class="alert alert-danger">An Error Occured.Please Contact Administrator.</div>');
                },
                success: function (data) {

                    if(data.error === true){
                        $("div.roll-content").html('<div class="alert alert-danger">'+ data.message +'</div>');
                        return 0;
                    }

                    $("div.roll-content").html(data);
                    $('#users').DataTable({
                        "bPaginate": false,
                        bFilter: false,
                        bInfo: false
                    });



                }
            });

        });
    </script>


    <?php




}catch (PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    return_error($return);
}