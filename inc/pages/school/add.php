<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */


try{

    //SELECT ALL COUNTRIES TO ADD SELECT OPTIONS
    $country_array = array();
    $countries = $PDO->query("SELECT `id`,`country_name` FROM `countries` ");

    //PUSH COUNTRY IDS AND COUNTRY NAME IN AN ARRAY
    while($country_data = $countries->fetch(PDO::FETCH_ASSOC)){
        array_push($country_array,$country_data);
    }

?>

<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mT-10 mB-30">Add New School</h4>

                        <form id="school_ad_form" action="/inc/ajax/school-add" method="POST"  class="needs-validation not-valid" novalidate>

                            <fieldset>

                        <div class="form-group row">

                            <label for="" class="col-sm-2 col-form-label"><strong>School Name <span class="text-danger">*</span></strong></label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="school_name" style="text-transform: " placeholder="e.g. Kadıköy Anadolu Lisesi" required>

                                <div class="invalid-feedback">
                                    Please enter a valid school name.
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="" class="col-sm-2 col-form-label"><strong>Advisor <span class="text-danger">*</span></strong></label>

                            <div class="col-sm-4">
                                <select class="form-control" name="advisor_id" required>
                                    <option value="">Please Select...</option>
                                    <?php
                                    //SELECT ALL ADVISROS FROM phpauth_users TABLE
                                    //DISPLAY THEM IN SELECT OPTIONS
                                    $query = $PDO->query(
                                        "SELECT `id`,CONCAT(`name`,' ',`surname`) as name FROM `phpauth_users` WHERE `auth` = '3' ");

                                    //DISPLAY ADVISORS IN LOOP
                                    while($data = $query->fetch(PDO::FETCH_ASSOC))
                                    {
                                        ?>
                                        <option value="<?=$data["id"]?>"><?=$data["name"]?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                                <div class="invalid-feedback">
                                    Please select a user.
                                </div>
                            </div>
                        </div>

                                <hr>
                        <h4>Quota</h4>
                        <hr>

                        <?php

                                    //SELECT COMMITEES
                                    $query = $PDO->query(
                                        "SELECT * FROM `committees`");


                                    while($data = $query->fetch(PDO::FETCH_ASSOC))
                                    {
                                        ?>

                        <div class="form-group row commitee-<?=$data["id"]?>">

                            <label for="" class="col-sm-2 col-form-label">
                                <strong class="committee-name"><?=$data["committee_name"]?> </strong>
                            </label>

                            <div class="col-sm-3">
                                <select type="text" class="form-control committee_country" name="quotas[<?=$data["id"]?>][country][]" >
                                    <option value="">Please Select...</option>
                                    <?php
                                    for($i = 0; $i < count($country_array) ; $i++ ){

                                    ?>
                                        <option value="<?=$country_array[$i]["id"]?>"><?=$country_array[$i]["country_name"]?></option>

                                    <?php
                                    }
                                    ?>

                                </select>

                            </div>
                                <label for="" class="col-sm-1 ">
                                    <input type="number" class="form-control" name="quotas[<?=$data["id"]?>][quota][]" min="0" max="20" value="0">
                                </label>


                            <div class="col-sm-1">
                                <div class="input-group-btn">
                                    <button class="btn btn-success add" type="button"  onclick="education_fields('commitee-<?=$data["id"]?>');"> <span class="fa fa-plus" aria-hidden="true"></span> </button>
                                </div>
                            </div>



                        </div>

                                        <div class="import-field commitee-<?=$data["id"]?>">



                                        </div>
                                        <hr>
                                        <?php
                                    }
                        ?>
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

        function  education_fields(a) {
            var to_import = $(".form-group."+a).html();
            var b = $($(to_import));
            var formgroup = $("<div></div>").addClass("form-group row toDelete");
            b.find("select").prop('selectedIndex',0);
            b.find("input[type=number]").val("0");
            b.find(".committee-name").html("");
            b.find(".btn.add").removeClass("btn-success").addClass("btn-danger").attr("onclick","delete_itself($(this))")
                .find("span.fa.fa-plus").removeClass("fa-plus").addClass("fa-minus");
            formgroup.append(b);
            $(".import-field."+a).append(formgroup);
        }

        function delete_itself(a){
            a.parents("div.form-group.toDelete").eq(0).remove();
        }



        //Example starter JavaScript for disabling form submissions if there are invalid fields
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
                                url: "/inc/ajax/school-add",
                                data: $("#school_ad_form").serializeArray(),
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

                                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/school/list'>List Schools</a></div>");



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
