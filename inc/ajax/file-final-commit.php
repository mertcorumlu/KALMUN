<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 02/06/2018
 * Time: 23:30
 */

//LOAD APP
include '../loader.php';

//CHECK IF REQUEST TRUE
if(empty($_GET["unique_id"]) ){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(2));

$return = array(
    "error" => true,
    "message" => ""
);

try{

    ?>

    <div class="container-fluid" style="padding:0;">
        <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
        <div class="row">

            <div class="col-md-12" style="padding:0;">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mT-10 mB-30">Final Commit</h4>

                    <form id="file-commit-form" action="/inc/ajax/file-final-commit-post.php" method="POST" enctype="multipart/form-data"  class="needs-validation" >

                        <fieldset>

                            <div class="form-group row">

                                <label for=""  class="col-sm-2 col-form-label"><strong>File Status <span class="text-danger">*</span></strong></label>

                                <div class="col-sm-4">
                                    <select id="selectStatue" class="form-control" name="file_status" required>
                                        <option value="">Please Select...</option>
                                        <option value="3">Reject</option>
                                        <option value="5">Passed</option>

                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label"><strong>File <span class="text-danger">*</span></strong></label>

                                <div class="col-sm-4">

                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" class="form-control border-0" type="file" accept=".doc,.docx,.pdf" name="file" disabled required>
                                    <small>Only *.doc , *.docx , *.pdf formats and files up to 10 Mb accepted</small>

                                    <br>
                                    <br>
                                    <div class="progress">
                                        <div class="progress-bar" style="width:0"></div>
                                    </div>
                                </div>

                            </div>

                            <input type="hidden" name="unique_id" value="<?=$_GET["unique_id"]?>">
                            <input type="hidden" name="type" value="file_final_commit">
                            <div class="alert message"></div>
                            <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>


                        </fieldset>



                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        var button = $("button[type=submit]");
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

        $("select[name=file_status]").on("change",function () {

            $("input[type=file]").attr("disabled",true);

            if($(this).val() === "5" ){
                $("input[type=file]").attr("disabled",false);
            }

        });

        button.on("click",function () {
            $("form#file-commit-form").ajaxForm({

                data: $(this).serializeArray(),
                type:"POST",
                beforeSend: function () {
                    show_loading(button);
                },
                uploadProgress : function (olay,yuklenen,toplam,yuzde) {
                    $(".progress .progress-bar").html(yuzde+"%").css("width",yuzde+"%");
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

                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/files/list'>List Files</a></div>");



                }

            }).submit();
        });


    </script>
    <script src="/inc/js/file.js"></script>

    <?php

}catch (PDOException $e){
    $return = array(
        "error" => true,
        "message" => $e->getMessage()
    );
    $PDO->rollback();
    return_error($return);
}

