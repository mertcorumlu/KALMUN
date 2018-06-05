<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */


try{


?>

<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mT-10 mB-30">Add New Session</h4>

                        <form id="committee_add_form" action="/inc/ajax/session-add" method="POST"  class="needs-validation not-valid" novalidate>

                            <fieldset>

                        <div class="form-group row">

                            <label for="" class="col-sm-2 col-form-label"><strong>Session Name <span class="text-danger">*</span></strong></label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="session_name" style="text-transform: " placeholder="e.g. 06/03/2018 Session 1" required>

                                <div class="invalid-feedback">
                                    Please enter a valid session name.
                                </div>
                            </div>
                        </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Session Start <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="session_start" style="text-transform: " required>

                                        <div class="invalid-feedback">
                                            Please select a valid date.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Session End <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="session_end" style="text-transform: " required>

                                        <div class="invalid-feedback">
                                            Please select a valid date.
                                        </div>
                                    </div>
                                </div>


                            <hr>
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

                            $.ajax({
                                type: "POST",
                                url: "/inc/ajax/session-add",
                                data: $("#committee_add_form").serializeArray(),
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

                                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/sessions/list'>List Sessions</a></div>");



                                }
                            });

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
