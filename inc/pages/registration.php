<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 01:54
 */

//IF LOGGED IN REDIRECT HOME PAGE
if($auth->isLogged()){
    redirect("/");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="/inc/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/inc/css/bootstrap-formhelpers.min.css">
    <link rel="stylesheet" href="/inc/css/font-awesome.css"/>

    <?=$head."\n"?>
</head>
<style>
    div.container{
        margin: 25px auto 100px auto;
        padding: 0 10% 0 10%;
    }
    input[type=text]{
        text-transform: capitalize;
    }
</style>
<div class="container">

    <img src="/inc/img/kalmun-logo.png" alt="KALMUN" width="150" height="150" style="display:block;margin: 0 auto;">
    <form id="apply-form" class="needs-validation not-valid"  method="POST" novalidate>

        <?php

        //INCLUDE REGISTRATION TYPE
        switch (get("subpage")){

            case "school-registration" :
                include("inc/pages/school-registration.php");
                break;

            case "individual-registration":
                include("inc/pages/individual-registration.php");
                break;

        }
        ?>

        <div class="alert text-center message"></div>

        <button type="submit" class="btn btn-primary float-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>
</div>

<script>
    var button = $("button[type=submit]");

        $("#apply-form").on("submit",function (e) {
            e.preventDefault();

            if(!$("#apply-form").hasClass("not-valid")){

                $.ajax({
                    type: "POST",
                    url: "/inc/ajax/registration.php",
                    data: $("#apply-form input,#apply-form select,#apply-form textarea").serializeArray(),
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
                            $(".alert.message").addClass("alert-danger").html(data.message).slideDown();
                            return 0;
                        }

                        $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br></div>");


                    }
                });
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
                        $("#apply-form").triggerHandler("submit");

                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<script src="/inc/js/popper.min.js"></script>
<script src="/inc/js/bootstrap.min.js"></script>
<script src="/inc/js/bootstrap-formhelpers.min.js"></script>

</body>
</html>

