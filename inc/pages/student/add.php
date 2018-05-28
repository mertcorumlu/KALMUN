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

                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="c-grey-900 mT-10 mB-30">You Can Add</h4>
                                    <hr>
                                    <?php
                                    /*
                                     * COUNT ALREADY ASSIGNED USERS
                                     *
                                     */
                                    $countTotal =0;
                                    $totalRegistered = array();
                                    $structure = $PDO->query("
                                            SELECT
                                             committees.id AS `committee_id`,
                                            committees.committee_name,
                                            countries.id AS `country_id`,
                                            countries.country_name,
                                            countries.flag,
                                              COUNT(DISTINCT phpauth_users.id) AS `quota`
                                            FROM
                                              `phpauth_users`
                                            INNER JOIN
                                              `committees`
                                            ON
                                              committees.id = phpauth_users.committee_id
                                            INNER JOIN
                                              `countries`
                                            ON
                                              countries.id = phpauth_users.country_id
                                            WHERE
                                              phpauth_users.school_id = '{$userData["advisor_school"]}'
                                            GROUP BY
                                              committee_id,
                                              country_id 
                                           ");


                                    /*
                                     * DISPLAY DELEGATE STRUCTURE
                                     */
                                    while ($structure_data = $structure->fetch(PDO::FETCH_ASSOC)){
                                        $totalRegistered[(int) $structure_data["committee_id"]][ (int) $structure_data["country_id"]] =(int) $structure_data["quota"];
                                    }

                                    /*
                                     *
                                     * Calculate How Many Left
                                     *
                                     */

                                    $structure = $PDO->query("
                                            SELECT 
                                            committees.id AS `committee_id`,
                                            committees.committee_name,
                                            countries.id AS `country_id`,
                                            countries.country_name,
                                            countries.flag,
                                            committee_structure.quota
                                            FROM 
                                            `committee_structure` 
                                            INNER JOIN 
                                            `countries` 
                                            ON 
                                            committee_structure.country_id = countries.id 
                                            INNER JOIN 
                                            `committees` 
                                            ON 
                                            committee_structure.committee_id = committees.id 
                                            WHERE 
                                            `school_id` = '{$userData["advisor_school"]}'  ");


                                    /*
                                     * DISPLAY DELEGATE STRUCTURE
                                     */

                                   $countries = array() ;
                                   $committees = array();


                                    while ($structure_data = $structure->fetch(PDO::FETCH_ASSOC)){


                                        $toBringOut = @$totalRegistered[$structure_data["committee_id"]][$structure_data["country_id"]];
                                        if(!isset($toBringOut)){
                                            $toBringOut = 0;
                                        }



                                        if($structure_data["quota"] - ($toBringOut) > 0){

                                            $countries[$structure_data["country_id"]] = $structure_data["country_name"];

                                            if(!isset($committees[$structure_data["country_id"]])){
                                                $committees[$structure_data["country_id"]] = array();
                                            }

                                            array_push($committees[$structure_data["country_id"]],array(
                                                   "committee_id" => $structure_data["committee_id"],
                                                    "committee_name" =>$structure_data["committee_name"])
                                            );

                                        }else if ($structure_data["quota"] - ($toBringOut) < 0 ){
                                            echo "<div class=\"alert alert-danger\">You have an error in your structure.Please contact administrator.</div><br>";
                                            exit;

                                        }

                                        $countTotal += $structure_data["quota"] - ($toBringOut);
                                        echo
                                            "In 
                                                <strong>". $structure_data["committee_name"] . "</strong> 
                                                From 
                                                <strong>".$structure_data["country_name"]."</strong>
                                                <strong class=\"text-danger\">".($structure_data["quota"] - ($toBringOut))."</strong> Person <br>";
                                    }


                                    ?>

                                </div>



                                <div class="col-sm-6">
                                    <h4 class="c-grey-900 mT-10 mB-30">You Have Added</h4>
                                    <hr>
                                    <?php
                                    /*
                                     * DISPLAY A SCHOOLS DELEGATE STRUCTURE
                                     * JOINT WITH COUNTRY NAME AND COMMITTEE NAME
                                     *
                                     */

                                    $structure = $PDO->query("
                                            SELECT 
                                            committees.id AS `committee_id`,
                                            committees.committee_name,
                                            countries.id AS `countries_id`,
                                            countries.country_name,
                                            countries.flag,
                                          
                                              COUNT(DISTINCT phpauth_users.id) AS `quota`
                                            FROM
                                              `phpauth_users`
                                            RIGHT JOIN
                                              `committees`
                                            ON
                                              committees.id = phpauth_users.committee_id
                                            RIGHT JOIN
                                              `countries`
                                            ON
                                              countries.id = phpauth_users.country_id
                                            WHERE
                                              phpauth_users.school_id = '{$userData["advisor_school"]}'
                                            GROUP BY
                                              committee_id,
                                              country_id 
                                             ");


                                    /*
                                     * DISPLAY DELEGATE STRUCTURE
                                     */
                                    while ($structure_data = $structure->fetch(PDO::FETCH_ASSOC)){
                                        echo
                                            "In 
                                                <strong>". $structure_data["committee_name"] . "</strong> 
                                                From 
                                                <strong>".$structure_data["country_name"]."</strong>
                                                <strong class=\"text-danger\">".$structure_data["quota"]."</strong> Person <br>";
                                    }
                                    ?>

                                </div>
                            </div>

                            <?php
                            if ($countTotal == 0 ){
                                echo "<hr>
                                        <script >
                                        $(function() {
                                          $('form input,form select,form button').attr('disabled',true);
                                        });
                                        
</script>
                                    <div class=\"alert alert-success\">You have added all your students.You can edit them from students/list section </div><br>";

                            }

                            ?>



                            <hr>
                            <h4 class="c-grey-900 mT-10 mB-30">Add New Student</h4>

                            <form id="user_ad_form" action="/inc/ajax/user-add" method="POST"  class="needs-validation not-valid"  novalidate>

                                <fieldset>

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

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password </strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" id="password" class="form-control" name="user_password" style="text-transform: ">
                                        <small>If You Don't Set A Password,Users Password Will Be Automatically Created and Emailed</small>

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
                                        <select id="setSchool" class="form-control school_country"  required disabled>
                                            <?php

                                            //SELECT COMMITEES
                                            $query = $PDO->query(
                                                "SELECT `school_name` FROM `schools` WHERE `advisor_id` = {$userData["id"]} LIMIT 1");

                                            //DISPLAY ALL COMMITTEES
                                            while($data = $query->fetch(PDO::FETCH_ASSOC))
                                            {
                                                ?>

                                                <option value="" selected><?=$data["school_name"]?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <small class="text-danger">Please Contact Administrators To Change Your School</small>
                                        <div class="invalid-feedback">
                                            Please select a school.
                                        </div>
                                    </div>
                                </div>


                                <hr>
                                <h4>Committee Info</h4>
                                <hr>

                                <!--                                LIST COUNTRIES-->
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Represented Country <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="setCountry" class="form-control school_country" name="user_represented_country_id" required>
                                            <option value="">Please Select...</option>
                                            <?php
                                            //DISPLAY COUNTRIES IN SELECT OPTION
                                            foreach ($countries as $a => $b){

                                                ?>
                                                <option value="<?=$a?>"><?=$b?></option>

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

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Committee.
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="user_school_id" value="<?=$userData["advisor_school"]?>">

                                <hr>
                                <div class="alert message"></div>
                                <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>
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

        var comm =
        <?php
           echo json_encode($committees);
        ?>;

        $("#setCountry").on("change",function () {

            $("#setCommittee option[class=toRemove]").remove();

            if( $(this).val() === ""){
                $("#setCommittee").attr("disabled",true);
                return;
            }

           for(var i =0;i< comm[$(this).val()].length ;i++){
               $("#setCommittee").append('<option class="toRemove" value="'+comm[$(this).val()][i]["committee_id"]+'" >'+comm[$(this).val()][i]["committee_name"]+'</option>');
           }

            $("#setCommittee").attr("disabled",false);


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


        // Example starter JavaScript for disabling form submissions if there are invalid fields
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

                                    $("form").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href='/student/add'>Continue Adding Users</a></div>");



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
