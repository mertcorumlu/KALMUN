<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 06/05/2018
 * Time: 23:56
 */

include("../loader.php");

$return=array("return"=>true,"message"=>"");
if($auth->isLogged()){
    $return["message"]="User Already Logged In.";
    return_error($return);
}

if(post("user_email")=="" || post("user_password")=="" ){
    $return["message"]="Email Or Password Cannot Be Empty.";
    return_error($return);
}

$return = $auth->login(post("user_email"),post("user_password"),post("remember_me"));

if($return["return"]==true){
    return_error($return);
}



if(post("remember_me")=="1"){
    setcookie($auth->config->cookie_name,$return["hash"],$return["expire"],$auth->config->cookie_path );
}else{
    setcookie($auth->config->cookie_name,$return["hash"],0,$auth->config->cookie_path );
}

unset($return["hash"]);
unset($return["expire"]);
unset($return["cookie_name"]);
return_error($return);





