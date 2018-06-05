<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */


try{

    //SELECT ALL COUNTRIES BELONG TO CHAIR
    $countries = $PDO->query(
        "SELECT
                  countries.country_name,
                  countries.id as country_id
                FROM
                  `phpauth_users`
                  LEFT JOIN
                  `countries`
                    ON
                      countries.id = phpauth_users.country_id
                WHERE
                  committee_id = {$userData["committee_id"]} 
                  AND 
                  phpauth_users.auth = 4
                GROUP BY phpauth_users.country_id
                  
                  ");




    ?>

    <main class="main-content bgc-grey-100">
        <div id="mainContent">

            <div class="container-fluid" style="padding:0;">
                <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
                <div class="row">

                    <div class="col-md-12" style="padding:0;">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <h4 class="c-grey-900 mT-10 mB-30">Commit A New File</h4>

                            <form id="file-commit-form" action="/inc/ajax/file-upload" method="POST" enctype="multipart/form-data"  class="needs-validation not-valid" novalidate>

                                <fieldset>

                                    <div class="form-group row">

                                        <label for=""  class="col-sm-1 col-form-label"><strong>Country <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <select id="selectStatue" class="form-control" name="country_id" required>
                                                <option value="">Please Select...</option>
                                                <?php
                                                    while($countries_fetch = $countries->fetch(PDO::FETCH_ASSOC)){

                                                    ?>
                                                    <option value="<?=$countries_fetch["country_id"]?>"><?=$countries_fetch["country_name"]?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                            <div class="invalid-feedback">
                                                Please select a statue.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-1 col-form-label"><strong>File <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">

                                                <!-- The file input field used as target for the file upload widget -->
                                         <input id="fileupload" class="form-control border-0" type="file" accept=".doc,.docx,.pdf" name="file" required>
                                            <small>Only *.doc , *.docx , *.pdf formats and files up to 10 Mb accepted</small>

                                            <br>
                                            <br>
                                            <div class="progress">
                                                <div class="progress-bar" style="width:0"></div>
                                            </div>
                                        </div>

                                    </div>

                                    <input type="hidden" name="committee_id" value="<?=$userData["committee_id"]?>">
                                    <input type="hidden" name="type" value="first_commit">


                                    <div class="alert message"></div>
                                    <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>


                                </fieldset>



                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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


        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('not-valid');
                        }else if(form.checkValidity() === true){

                            form.classList.remove("not-valid");

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


                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <?php

}catch(PDOException $e){
    trigger_error($e->errorInfo[2]);
}
?>