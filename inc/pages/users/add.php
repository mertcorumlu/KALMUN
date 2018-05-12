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
                            <h4 class="c-grey-900 mT-10 mB-30">Add New User</h4>

                            <form id="user_ad_form" action="/inc/ajax/user-add" method="POST"  class="needs-validation not-valid" novalidate>


                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="user_name" style="text-transform: " placeholder="e.g. Alara" required>

                                        <small>First Name</small>
                                        <div class="invalid-feedback">
                                            Please enter a valid name.
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="user_last_name" style="text-transform: " placeholder="e.g. Kara" required>

                                        <small>Last Name</small>
                                        <div class="invalid-feedback">
                                            Please enter a valid last name.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for=""  class="col-sm-2 col-form-label"><strong>Statue <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="selectStatue" class="form-control" name="user_statue" required>
                                            <option value="">Please Select...</option>
                                           <?php
                                            //DISPLAY STATUES
                                            foreach($Auth_Statues as $key => $value)
                                            {
                                                if($key == "0" || $key == "1"){
                                                    continue;
                                                }
                                                ?>
                                                <option value="<?=$key?>"><?=$value?></option>
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

                                    <label for="" class="col-sm-2 col-form-label"><strong>Individual Delegate <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="setIndividual" class="form-control" name="user_is_individual" required disabled>
                                            <option value="">Please Select...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>

                                        <small class="text-danger">You Must Select When You Select Delegate</small>
                                        <div class="invalid-feedback">
                                            Please select.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" id="password" class="form-control" name="user_password" style="text-transform: ">
                                        <small>If You Don't Set A Password,Users Password Will Automatically Sent</small>

                                    </div>

                                    <div class="col-sm-4">
                                        <input type="checkbox" id="senMail" class="form-check-input" name="user_send_mail" value="1">
                                        <label for="senMail" class="form-check-label">Send User His/Her Password</label>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>E-Mail <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" name="user_email" style="text-transform: " placeholder="e.g. example@example.com" required>

                                        <div class="invalid-feedback">
                                            Please enter a valid email.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Telephone <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="tel" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="user_telephone" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid telephone.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Country <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select class="input-medium bfh-countries form-control" data-countryList="US,AG,AU"
                                                data-country="TR" name="user_country" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid country.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>School <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="setSchool" class="form-control school_country" name="user_school_id" required disabled>
                                            <option value="">Please Select...</option>
                                            <?php

                                            //SELECT COMMITEES
                                            $query = $PDO->query(
                                                "SELECT * FROM `schools`");

                                            //DISPLAY ALL COMMITTEES
                                            while($data = $query->fetch(PDO::FETCH_ASSOC))
                                            {
                                                ?>

                                                <option value="<?=$data["id"]?>"><?=$data["school_name"]?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <small class="text-danger">Only School Delegates Can Have A School</small>
                                        <div class="invalid-feedback">
                                            Please select a school.
                                        </div>
                                    </div>
                                </div>


                                <hr>
                                <h4>Committee Info</h4>
                                <small><span class="text-danger">Only Available For <strong>Delegates and Chairs</strong>.<br>Advisors Country and School Can Be Added From <strong>Schools</strong> Section. </span></small>
                                <hr>

                                <!--                                LIST COUNTRIES-->
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Represented Country <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="setCountry" class="form-control school_country" name="user_represented_country_id" required disabled>
                                            <option value="">Please Select...</option>
                                            <?php
                                            //DISPLAY COUNTRIES IN SELECT OPTION
                                            for($i = 0; $i < count($country_array) ; $i++ ){

                                                ?>
                                                <option value="<?=$country_array[$i]["id"]?>"><?=$country_array[$i]["country_name"]?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a country.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Committee <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="setCommittee" class="form-control school_country" name="user_committee_id" required disabled>
                                            <option value="">Please Select...</option>
                                            <?php

                                            //SELECT COMMITEES
                                            $query = $PDO->query(
                                                "SELECT * FROM `committees`");

                                            //DISPLAY ALL COMMITTEES
                                            while($data = $query->fetch(PDO::FETCH_ASSOC))
                                            {
                                                ?>

                                                <option value="<?=$data["id"]?>"><?=$data["committee_name"]?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Committee.
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Is Active <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select  class="form-control" name="user_is_active" required>
                                            <option value="">Please Select...</option>
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        </select>

                                        <div class="invalid-feedback">
                                            Please select is active.
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="alert message"></div>
                                <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        var button = $("button[type=submit]");

        $("#user_ad_form").submit(function (e) {
            e.preventDefault();

            if(!$("#user_ad_form").hasClass("not-valid")){

                $.ajax({
                    type: "POST",
                    url: "/inc/ajax/user-add",
                    data: $("#user_ad_form").serializeArray(),
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

                        $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/users/list'>List Users</a></div>");



                    }
                });
            }



        });

        $("#selectStatue").bind("change",function () {

            $("#setIndividual").attr("disabled",true);
            $("#setSchool").attr("disabled",true);
            $("#setCommittee").attr("disabled",true);
            $("#setCountry").attr("disabled",true);

            if( $(this).val() === "4" /*IF DELEGATE*/){

                $("#setIndividual").attr("disabled",false);
                $("#setCommittee").attr("disabled",false);
                $("#setCountry").attr("disabled",false);

            }else if($(this).val() === "2" /*CHAIR*/){

                $("#setCommittee").attr("disabled",false);

            }


        });

        $("#setIndividual").bind("change",function () {
            $("#setSchool").attr("disabled",true);
            if( $(this).val() === "0" ){
                $("#setSchool").attr("disabled",false);
            }

        });


        function show_loading(a){
            a.data("original-text",a.html());
            a.attr("disabled", true);
            a.html(a.data("loading-text"));
        }

        function hide_loading(a){
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
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('not-valid');
                        }else if(form.checkValidity() === true){

                            form.classList.remove("not-valid");
                            $("#school_ad_form").triggerHandler("submit");

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
