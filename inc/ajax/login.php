<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:56
 */

//LOAD APP
include("../loader.php");

//SET RETURN ARRAY
$return=array(
    "error"=>true,
    "message"=>""
);

//CHECK IF USER IS ALREADY LOGGED IN
if($auth->isLogged()){
    $return["message"]="User Already Logged In.";
    return_error($return);
}

//CHECK REQUEST PARAMETERS
if(post("user_email")=="" || post("user_password")=="" ){
    $return["message"]="Email Or Password Cannot Be Empty";
    return_error($return);
}

//MAKE LOGIN WITH PHPAUTH
$return = $auth->login(post("user_email"),post("user_password"),(int) post("remember_me"));

//HANDLE LOGIN ERRORS
if($return["error"]==true){
    return_error($return);
}



//SET COOKIES
if(post("remember_me")=="1"){
    setcookie($auth->config->cookie_name,$return["hash"],$return["expire"],$auth->config->cookie_path );
}else{
    setcookie($auth->config->cookie_name,$return["hash"],0,$auth->config->cookie_path );
}

//IF EVERYTHING WENT RIGHT,INFORM USER
//JUST HIDE UNNECESSARY INFORMATION
unset($return["hash"]);
unset($return["expire"]);
unset($return["cookie_name"]);
return_error($return);





