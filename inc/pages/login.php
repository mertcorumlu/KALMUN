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
        <form action="/ajax/login" id="login_form">

            <div class="form-group">
                <label for="InputEmail1">Email address</label>
                <input type="email" class="form-control" id="InputEmail1" placeholder="Enter email" name="user_email">
            </div>
            <div class="form-group">
                <label for="InputPassword1">Password</label>
                <input type="password" class="form-control" id="InputPassword1" placeholder="Password" name="user_password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="Check1" name="remember_me" value="1">
                <label class="form-check-label" for="Check1">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <script>
            $("#login_form").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "inc/ajax/login.php",
                    data: $("#login_form input").serialize(),
                    success: function (result) {
                        console.log(result);
                    }
                });


            });

        </script>
    </div>
</div>
<script src="/inc/js/bootstrap.min.js"></script>
</body>
</html>
