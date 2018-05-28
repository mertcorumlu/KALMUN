<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */


    ?>

    <main class="main-content bgc-grey-100">
        <div id="mainContent">

            <div class="container-fluid" style="padding:0;">
                <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
                <div class="row">

                    <div class="col-md-12" style="padding:0;">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <h4 class="c-grey-900 mT-10 mB-30">My Profile</h4>

                            <form id="profile_update_form" action="/inc/ajax/profile-edit" method="POST"  class="needs-validation not-valid" novalidate>

                                <fieldset>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Statue </strong></label>

                                        <div class="col-sm-4">
                                            <span>
                                                <strong>
                                            <?php
                                            switch ($userData["auth"]){

                                                case 0;
                                                    echo '<span class="text-secondary">'.$Auth_Statues[$userData["auth"]].'</span>';
                                                    break;

                                                case 1;
                                                    echo '<span class="text-danger">'.$Auth_Statues[$userData["auth"]].'</span>';
                                                    break;

                                                case 2;
                                                    echo '<span class="text-success">'.$Auth_Statues[$userData["auth"]].'</span>';
                                                    break;

                                                case 3;
                                                    echo '<span class="text-warning">'.$Auth_Statues[$userData["auth"]].'</span>';
                                                    break;

                                                case 4;
                                                    echo '<span class="text-primary">'.$Auth_Statues[$userData["auth"]].'</span>';
                                                    break;


                                            }
                                            ?>
                                                </strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>School</strong></label>

                                        <div class="col-sm-4">
                                            <span><?=$userData["school_name"]?></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Country</strong></label>

                                        <div class="col-sm-4">
                                            <span>
                                                <div class=" <?=$userData["flag"] != "" ? "flag flag-".strtolower($userData["flag"]) :"" ?>" style="vertical-align: middle"></div><?=$userData["country_name"]?></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Committee</strong></label>

                                        <div class="col-sm-4">
                                            <span><?=$userData["committee_name"]?></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="user_name" style="text-transform: " placeholder="e.g. Alara" value="<?=$userData["name"]?>" required>

                                            <small>First Name</small>
                                            <div class="invalid-feedback">
                                                Please enter a valid name.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="user_last_name" style="text-transform: " placeholder="e.g. Kara" value="<?=$userData["surname"]?>" required>

                                            <small>Last Name</small>
                                            <div class="invalid-feedback">
                                                Please enter a valid last name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>E-Mail <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" name="user_email" style="text-transform: " placeholder="e.g. example@example.com" value="<?=$userData["email"]?>" required>

                                            <div class="invalid-feedback">
                                                Please enter a valid email.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Telephone <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <input type="tel" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="user_telephone" value="<?=$userData["telephone"]?>" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid telephone.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Country <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <select class="input-medium bfh-countries form-control" data-countryList="US,AG,AU"
                                                    data-country="<?=$userData["country"]?>" name="user_country" required>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid country.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Password <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <input type="password" id="password" class="form-control" name="user_password" style="text-transform: ">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label for="" class="col-sm-2 col-form-label"><strong>Repeat Password <span class="text-danger">*</span></strong></label>

                                        <div class="col-sm-4">
                                            <input type="password" id="password_repeat" class="form-control" name="user_password_repeat" style="text-transform: ">
                                            <small>If You Don't Set A Password,Your Password Will Not Be Changed</small>

                                        </div>
                                    </div>

                                    <div class="alert message"></div>
                                    <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Update</button>


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
                                url: "/inc/ajax/profile-edit",
                                data: $("#profile_update_form").serializeArray(),
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

                                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/profile'>Return Profile</a></div>");



                                }
                            });

                        }
                        form.classList.add('was-validated');
                        return false;
                    }, false);
                });
            }, false);
        })();
    </script>

