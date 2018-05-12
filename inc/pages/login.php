<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <script src="/inc/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/inc/css/bootstrap-formhelpers.min.css">
    <link rel="stylesheet" href="/inc/css/stylesheet.css"/>

</head>
<body class="app">
<div id='loader'>
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
<div class="peers ai-s fxw-nw h-100vh">
    <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url("/inc/img/bg.jpg")'>
        <div class="pos-a centerXY">
            <div class="bgc-white bdrs-50p pos-r" style='width: 120px; height: 120px;'>
                <img class="pos-a centerXY" src="/inc/img/logo.png" alt="">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
        <h4 class="fw-300 c-grey-900 mB-40">Login</h4>
        <form action="/ajax/login" method="POST" id="login_form" class="needs-validation not-valid"  novalidate>

            <div class="alert message" style="display: none"></div>
            <div class="form-group">
                <label for="InputEmail1">Email address</label>
                <input type="email" class="form-control" id="InputEmail1" placeholder="Enter email" name="user_email" required>
                <div class="invalid-feedback">
                    Please enter an email.
                </div>
            </div>
            <div class="form-group">
                <label for="InputPassword1">Password</label>
                <input type="password" class="form-control" id="InputPassword1" placeholder="Password" name="user_password" required>
                <div class="invalid-feedback">
                    Please enter a password.
                </div>
            </div>

            <div class="form-check">

                <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                    <input type="checkbox" class="custom-control-input" id="Check1" name="remember_me" value="1">
                    <label class="custom-control-label" for="Check1">Remember Me</label>
                </div>

            </div>

            <br>
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." class="btn btn-primary">Submit</button>
        </form>
        <script>
            var button = $("button[type=submit]");

            $("#login_form").on("submit",function (e) {
                e.preventDefault();

                if(!$("#login_form").hasClass("not-valid")){

                    $.ajax({
                        type: "POST",
                        url: "/inc/ajax/login",
                        data: $("#login_form").serializeArray(),
                        beforeSend:function () {
                            show_loading(button);
                        },
                        error:function () {
                            $(".alert.message").addClass("alert-danger").html("An Error Occured.Please Contact Administrator.").slideDown();
                            hide_loading(button);
                        },
                        success: function (data) {
                            if(data.error === true){
                                hide_loading(button);
                                $(".alert.message").addClass("alert-danger").html(data.message).slideDown();
                                return 0;
                            }

                            $(".alert.message").addClass("alert-success").html(data.message);
                            location.reload();



                        }
                    });
                }



            });

            function show_loading(a){
                $("#login_form input").attr("disabled",true);
                a.data("original-text",a.html());
                a.attr("disabled", true);
                a.html(a.data("loading-text"));
            }

            function hide_loading(a){
                $("#login_form").removeClass("was-validated").addClass("not-valid");
                $("#login_form input").attr("disabled",false);
                $("#login_form input[type=password]").val("");
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
                                $("#login_form").triggerHandler("submit");

                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
            </script>
    </div>
</div>
<script src="/inc/js/bootstrap.min.js"></script>
</body>
</html>
