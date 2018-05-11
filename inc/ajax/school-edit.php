<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 20:17
 */

//LOAD APP
include '../loader.php';

//CHECK PHP REQUEST
if(empty(get("id"))){
    http_response_code(404);
    exit;
}

//CHECK IF USER LOGGED IN,OR IS AUTHORIZED
check_login($PDO,$auth,array(0,1));


try{
    //ARRAY TO COUNT COUNTRIES
$country_array = array();

//SELECT ALL SCHOLS,PUSH INTO ARRAY
$countries = $PDO->query("SELECT * FROM `countries` ");
while($country_data = $countries->fetch(PDO::FETCH_ASSOC)){
    array_push($country_array,$country_data);
}

    //SELECT THE PROVIDED SCHOOL
    $school_data = $PDO->query("
                                                                      SELECT 
                                                                      schools.id,
                                                                      schools.school_name,
                                                                      schools.advisor_id,
                                                                      schools.country_id
                                                                       FROM 
                                                                       `schools` 
                                                                       WHERE
                                                                       `id` = {$_GET["id"]}
                                                                       LIMIT 1
                                                                        ")->fetch(PDO::FETCH_ASSOC);


?>




            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mT-10 mB-30">Edit School</h4>

                        <form id="school_edit_form" action="" method="POST"  class="needs-validation" >


                            <div class="form-group row">

                                <label for="" class="col-sm-2 col-form-label"><strong>ID </strong></label>
                                <input type="hidden" name="school_id" value="<?=$school_data["id"]?>">

                                <div class="col-sm-4">
                                    <span><?=$school_data["id"]?></span>
                            </div>
                            </div>

                            <div class="form-group row">

                                <label for="" class="col-sm-2 col-form-label"><strong>School Name <span class="text-danger">*</span></strong></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="school_name" style="text-transform: " placeholder="e.g. Kadıköy Anadolu Lisesi" value="<?=$school_data["school_name"]?>" required>

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
                                        //SELECT ADVISORS,DISLAY THEM IN A SELECT OPTION
                                        $query = $PDO->query(
                                            "SELECT `id`,CONCAT(`name`,' ',`surname`) as name FROM `phpauth_users` WHERE `auth` = '3' ");

                                        while($data = $query->fetch(PDO::FETCH_ASSOC))
                                        {
                                            ?>
                                            <option value="<?=$data["id"]?>" <?php echo $data["id"] == $school_data["advisor_id"] ? "selected" : "" ?>><?=$data["name"]?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a user.
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="" class="col-sm-2 col-form-label"><strong>Country <span class="text-danger">*</span></strong></label>

                                <div class="col-sm-4">
                                    <select class="form-control school_country" name="school_country_id" required>
                                        <option value="">Please Select...</option>
                                        <?php
                                        //DISPLAY ALLCOUNTRIES
                                        for($i = 0; $i < count($country_array) ; $i++ ){

                                            ?>
                                            <option value="<?=$country_array[$i]["id"]?>" <?php echo $country_array[$i]["id"] == $school_data["country_id"] ? "selected" : "" ?>><?=$country_array[$i]["country_name"]?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a country.
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4>Quota</h4>
                            <hr>

                            <?php


                            //SELECT ALL COMMITESS TO CREATE STRUCTURE
                            $query = $PDO->query(
                                "SELECT 
                                            committees.committee_name,
                                            committees.id,
                                            committee_structure.quota,
                                            committee_structure.country_id
                                            FROM 
                                            `committees` 
                                            LEFT JOIN 
                                            `committee_structure` 
                                            ON 
                                            committee_structure.committee_id = committees.id 
                                            AND 
                                            committee_structure.school_id = '{$_GET["id"]}' ");

                            //DISPLAY STRUCTURE
                            while($data = $query->fetch(PDO::FETCH_ASSOC))
                            {
                                ?>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label">
                                        <strong><?=$data["committee_name"]?> </strong>
                                    </label>

                                    <div class="col-sm-3">
                                        <select type="text" class="form-control committee_country" name="quotas[<?=$data["id"]?>][country]"  >
                                            <option value="">Please Select...</option>
                                            <?php
                                            //DISPLAY ALL COUNTRIES
                                            for($i = 0; $i < count($country_array) ; $i++ ){

                                                ?>
                                                <option value="<?=$country_array[$i]["id"]?>" <?php echo $country_array[$i]["id"] == $data["country_id"] ? "selected":""; ?>><?=$country_array[$i]["country_name"]?></option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                        <small>Please <span class="text-danger">Do Not</span> Change If You Are Not Interested In How To Use It.</small>

                                    </div>
                                    <label for="" class="col-sm-1 ">
                                        <input type="number" class="form-control" name="quotas[<?=$data["id"]?>][quota]" min="0" max="20" value="<?=$data["quota"]?>">
                                    </label>
                                </div>

                                <?php
                            }
                            ?>
                            <hr>
                            <div class="alert message"></div>
                            <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>


                        </form>

                    </div>
                </div>
            </div>


<script>

    var button = $("button[type=submit]");

    $("#school_edit_form").on("submit",function (e) {
        e.preventDefault();

        if(!$("#school_edit_form").hasClass("not-valid")){

            $.ajax({
                type: "POST",
                url: "/inc/ajax/school-edit-post",
                data: $("#school_edit_form input,#school_edit_form select,#school_edit_form textarea").serializeArray(),
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



    });

    $(".school_country").on("change",function(){
        var value = $(this).find(":selected").attr("value");
        $(".committee_country option").attr("selected",false);
        $(".committee_country option[value="+value+"]").attr("selected",true);
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
</script>

    <?php

}catch(PDOException $e){
    trigger_error($e->errorInfo[2]);
}
?>

