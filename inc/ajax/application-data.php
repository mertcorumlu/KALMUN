<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 09/05/2018
 * Time: 23:41
 */

include("../loader.php");

if(get("id")==""){
    http_response_code(404);
    exit;
}

check_login($PDO,$auth,array(0,1));

try{
    $id=get("id");
    $fetch = $PDO->query("SELECT * FROM `applications` WHERE `id`='{$id}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $data = json_decode($fetch["data"],true);
    error_reporting(0);

    if($fetch["type"]=="1"){




        ?>
        <form action=""></form>
        <hr>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Name of School <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$fetch["school"]?>
            </div>


        </div>


        <div class="form-group row">
            <label for="inputAddress" class="col-sm-3 col-form-label"><strong>Address <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_adress1"]?>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputAddress" class="col-sm-3 col-form-label"></label>

            <div class="col-sm-9">
                <?=$data["school_reg_adress2"]?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputState"><strong>Country <span class="text-danger">*</span></strong></label>

                        <label>
                            <?=$data["school_reg_country"]?>
                        </label>

                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputCity"><strong>City <span class="text-danger">*</span></strong></label>
                        <?=$data["school_reg_city"]?>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip"><strong>Zip <span class="text-danger">*</span></strong></label>
                        <?=$data["school_reg_zip"]?>
                    </div>
                </div>

            </div>

        </div>

        <hr>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Contact Email <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$fetch["email"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Contact Number <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$fetch["telephone"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Number of Advisors Attending  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_num_of_advisors"]?>

            </div>
        </div>


        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Full Name Of Advisors  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_advisor_last_name"]." ".$data["school_reg_advisor_last_name"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Telephone Of Advisors  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_advisor_phone"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Full Name Of Head Delegate  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_header_last_name"]." ".$data["school_reg_header_last_name"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Email of Head Delegate  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_header_email"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Telephone of Head Delegate  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_header_phone"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Delegation Size Preference  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_size_pref"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Do you require a visa ?  <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_visa"]?>

            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>Please indicate your top three country preferences in decreasing order. Please state your choices accordingly with our provisional Country Matrix.

                    <span class="text-danger">*</span></strong></label>

            <div class="col-sm-9">
                <?=$data["school_reg_pref"]?>

            </div>
        </div>

        <hr>


        <div class="alert alert-danger text-center message"></div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <label for="sendEmail">
                    Send Email Automatically
                    <input type="checkbox" id="sendEmail" name="checbox" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="button" class="btn btn-success button-approve" onclick="application_evaluate(<?=$id?>,'1')" style="margin-right:15px;" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Approve</button>
                <button type="button" class="btn btn-danger button-reject" onclick="application_evaluate(<?=$id?>,'2')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Reject</button>
            </div>

        </div>


        <?php
    }
    else
    if($fetch["type"]=="2"){



    ?>
    <form action=""></form>
        <hr>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Full Name <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$fetch["name"]." ".$fetch["last_name"]?>
        </div>


    </div>

        <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Date of Birth <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_birth"]?>
        </div>
    </div>
    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Nationality <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_nationality"]?>

        </div>
    </div>
    <hr>


    <div class="form-group row">
        <label for="inputAddress" class="col-sm-3 col-form-label"><strong>Address <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_adress1"]?>
    </div>
    </div>


    <div class="form-group row">
        <label for="inputAddress" class="col-sm-3 col-form-label"></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_adress2"]?>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputState"><strong>Country <span class="text-danger">*</span></strong></label>

                    <label>
                        <?=$data["ind_reg_country"]?>
                    </label>

                </div>
                <div class="form-group col-md-4">
                    <label for="inputCity"><strong>City <span class="text-danger">*</span></strong></label>
                    <?=$data["ind_reg_city"]?>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip"><strong>Zip <span class="text-danger">*</span></strong></label>
                    <?=$data["ind_reg_zip"]?>
                </div>
            </div>

        </div>

    </div>

    <hr>


    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Name Of School <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$fetch["school"]?>
        </div>
    </div>

    <hr>

    <div class="form-group row">
        <label for="inputAddress" class="col-sm-3 col-form-label"><strong>School Address <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_school_adress1"]?> <?=$data["ind_reg_school_adress2"]?>
    </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputState"><strong>Country <span class="text-danger">*</span></strong></label>

                    <?=$data["ind_reg_school_country"]?>

                    </label>

                </div>
                <div class="form-group col-md-4">
                    <label for="inputCity"><strong>City <span class="text-danger">*</span></strong></label>
                    <?=$data["ind_reg_school_city"]?>

                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip"><strong>Zip <span class="text-danger">*</span></strong></label>
                    <?=$data["ind_reg_school_zip"]?>

                </div>
            </div>

        </div>

    </div>

    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Graduation Year <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_graduation_year"]?>

        </div>
    </div>
    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Contact Number <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$fetch["telephone"]?>

        </div>
    </div>

    <hr>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Contact Email <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$fetch["email"]?>

        </div>
    </div>

    <hr>
<strong>
    Please state the conferences that you've attended.
    If you are a first timer you may omit the question but please bear in mind that your acceptance,
    committee and delegation allocation will be concluded in accordance with your experience.

</strong>
    <hr>

    <div class="form-group row" >
        <div class="col-sm-3">
            <strong>Position</strong>
        </div>

        <div class="col-sm-2">
            <strong>Year</strong>
        </div>

        <div class="col-sm-3">
            <strong>Name of the Conference</strong>
        </div>

        <div class="col-sm-3">
            <strong>Detail of the Position Held</strong>
        </div>

    </div>

    <?php
    for($i = 0;$i < (count($data["ind_reg_confs"]["conf_name"])) ;$i++){
    ?>



    <div class="form-group row">
        <div class="col-sm-3">
            <?=$data["ind_reg_confs"]["conf_position"][$i]?>
        </div>

        <div class="col-sm-2">
            <?=$data["ind_reg_confs"]["conf_year"][$i]?>
        </div>

        <div class="col-sm-3">
            <?=$data["ind_reg_confs"]["conf_name"][$i]?>
        </div>

        <div class="col-sm-3">
            <?=$data["ind_reg_confs"]["conf_position_held"][$i]?>
        </div>

        <div class="col-sm-1"></div>


    </div>
    <?php
    }
    ?>
    <hr>
    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Please state your top three committee preferences in decreasing order. Your application will be evaluated accordingly to this section, but the Secretariat does not guarantee your assignment to be in accordance with your preferences at all times. <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <div class="form-check row">
                <?php
                for($i = 0;$i < count($data["ind_reg_committee"]) ; $i++){

                    echo $data["ind_reg_committee"][$i]."<br>";

                    }?>
            </div>


        </div>
    </div>
    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Motivational Letter: Please indicate your past MUN experiences, eligibility and motivation for attending KALMUN 2018 as a participant in the Special Committees. (max. 350 words) <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_motv_letter"]?>
        </div>
    </div>
    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Please write an extensively detailed essay on a selected agenda item of the preferred committee of yours. (max. 350 words) <span class="text-danger">*</span></strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_essay"]?>

        </div>
    </div>
    <hr>

    <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label"><strong>Special Conditions.</strong></label>

        <div class="col-sm-9">
            <?=$data["ind_reg_spec_cond"]?>
        </div>
    </div>


        <div class="alert alert-danger text-center message"></div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <label for="sendEmail">
                    Send Email Automatically
                    <input type="checkbox" id="sendEmail" name="checbox" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="button" class="btn btn-success button-approve" onclick="application_evaluate(<?=$id?>,'1')" style="margin-right:15px;" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Approve</button>
                <button type="button" class="btn btn-danger button-reject" onclick="application_evaluate(<?=$id?>,'2')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Reject</button>
            </div>

        </div>


<?php
    }


}catch (PDOException $e){
    trigger_error($e->errorInfo[2]);
}
