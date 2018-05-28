<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 20:17
 */

//LOAD APP
include '../loader.php';

//CHECK PHP REQUEST
if(empty(get("id"))){
    http_response_code(400);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1));


try{

    //SELECT THE PROVIDED SCHOOL
    $select_query = $PDO->query("
                                                                      SELECT 
                                                                      *
                                                                       FROM 
                                                                       `committees` 
                                                                       WHERE
                                                                       `id` = {$_GET["id"]}
                                                                       LIMIT 1
                                                                        ");

    if($select_query->rowCount() < 1){
        echo '<div class="alert alert-danger" >No Such Committee!</div>';
        exit;
    }

    $committeeData = $select_query->fetch(PDO::FETCH_ASSOC);

    ?>




    <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
    <div class="row" xmlns="http://www.w3.org/1999/html">

        <div class="col-md-12" style="padding:0;">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mT-10 mB-30">Edit Committee</h4>

                <form id="committee_edit_form" action="" method="POST"  class="needs-validation" >

                    <fieldset>

                        <div class="form-group row">

                            <label for="" class="col-sm-2 col-form-label"><strong>ID </strong></label>
                            <input type="hidden" name="committee_id" value="<?=$committeeData["id"]?>">

                            <div class="col-sm-4">
                                <span><?=$committeeData["id"]?></span>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="" class="col-sm-2 col-form-label"><strong>Committee Name <span class="text-danger">*</span></strong></label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="committee_name" style="text-transform: " placeholder="e.g. OSSAS" value="<?=$committeeData["committee_name"]?>" required>

                                <div class="invalid-feedback">
                                    Please enter a valid committee name.
                                </div>
                            </div>
                        </div>


                        <div class="alert message"></div>
                        <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>


                    </fieldset>
                </form>

            </div>
        </div>
    </div>


    <script>

        var button = $("button[type=submit]");

        $("#committee_edit_form").on("submit",function (e) {
            e.preventDefault();

            if(!$("#committee_edit_form").hasClass("not-valid")){

                $.ajax({
                    type: "POST",
                    url: "/inc/ajax/committee-edit-post",
                    data: $("#committee_edit_form").serializeArray(),
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

                        $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/committee/list'>List Committees</a></div>");



                    }
                });
            }



        });

        $(".school_country").on("change",function(){
            var value = $(this).find(":selected").attr("value");
            $(".committee_country option").attr("selected",false);
            $(".committee_country option[value="+value+"]").attr("selected",true);
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

}catch(PDOException $e){
    trigger_error($e->errorInfo[2]);
}
?>

