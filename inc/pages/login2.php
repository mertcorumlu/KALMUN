<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:56
 */

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
    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
    <script src="/inc/js/jquery-3.3.1.min.js"></script>
    <style>
        html,body{
            height:100%;
        }

        div.outer{
            height:100%;
            padding:0;
            margin:0;
        }


        button[type=submit]{
            float:right;
            padding: 3% 6% 3% 6%;
        }


    </style>
</head>
<body>
<div class="jumbotron d-flex align-items-center outer">
    <div class="container" style="padding:0 25% 0 25%">
        <form action="ajax/login.php" id="login_form">

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="user_email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="user_password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me" value="1">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

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
<script src="/inc/js/popper.min.js"></script>
<script src="/inc/js/bootstrap.min.js"></script>
</body>
</html>
