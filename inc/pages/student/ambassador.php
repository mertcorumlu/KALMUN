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


                            <h4 class="c-grey-900 mT-10 mB-30">Choose Ambassadors</h4>

                            <form id="ambassador_select_form" action="/inc/ajax/ambassador-select" method="POST"  class="needs-validation not-valid"  novalidate>

                                <fieldset>

                                    <?php
                                    echo $userData["school_id"];
                                    $countries = $PDO->query("
                                    SELECT 
                                    country_id,
                                    countries.flag,
                                    countries.country_name 
                                    FROM 
                                    `phpauth_users` 
                                    LEFT JOIN
                                    countries
                                    ON 
                                    countries.id = phpauth_users.country_id
                                    WHERE 
                                    school_id = {$userData["advisor_school"]} 
                                    AND
                                    (
                                    committee_id = 1
                                    OR
                                    committee_id = 2
                                    OR
                                    committee_id = 3
                                    OR
                                    committee_id = 4
                                    )
                                    GROUP BY 
                                    country_id
                                    ");
                                    while($countryData = $countries->fetch(PDO::FETCH_ASSOC) ){



                                    ?>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>
                                                <div class=" <?=$countryData["flag"] != "" ? "flag flag-".strtolower($countryData["flag"]) :"" ?>" style="vertical-align: middle"></div><?=$countryData["country_name"]?></span>

                                                <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <select class="form-control" name="user_name" required>
                                                <option value="">Please Select...</option>
                                                <?php
                                                $ambs = $PDO->query("
                                                SELECT
                                                id,
                                                name,
                                                surname
                                                FROM
                                                `phpauth_users`
                                                WHERE
                                                school_id = {$userData["advisor_school"]}
                                                AND 
                                                country_id = {$countryData["country_id"]}
                                                ");

                                                while($ambsData = $ambs->fetch(PDO::FETCH_ASSOC)){


                                                ?>
                                                    <option value="<?=$ambsData["id"]?>"><?=$ambsData["name"]." ".$ambsData["surname"]?></option>
                                                <?php
                                               }
                                                ?>

                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid student.
                                            </div>
                                        </div>

                                    </div>

                                    <?php
                                 }
                                     ?>

                                    <hr>
                                    <div class="alert message"></div>
                                    <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>
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

                            $.ajax({
                                type: "POST",
                                url: "/inc/ajax/ambassador-select",
                                data: $("#ambassador_select_form").serializeArray(),
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

                                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/country/list'>List Countries</a></div>");



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
