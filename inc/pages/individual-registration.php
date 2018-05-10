<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 07/05/2018
 * Time: 11:27
 */
?>

<br>
<hr>


<h1>KALMUN 2018 - Individual Delegate</h1>
<p>This form is to apply KALMUN 2018 as an individual participant in the Special Committees.
    Before submitting your application, please see kalmun.org/information for crucial points regarding the application process.
    By filling out this form, you will automatically agree to our terms and conditions.</p>

<hr>
<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Full Name <span class="text-danger">*</span></strong></label>

    <div class="col-sm-4">
        <input type="text" class="form-control" placeholder="Arda" name="ind_reg_name" required>
        <small>Name</small>
        <div class="invalid-feedback">
            Please enter a valid name.
        </div>
    </div>

    <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Karasulu" name="ind_reg_last_name" required>
        <small>Last Name</small>
        <div class="invalid-feedback">
            Please enter a valid name.
        </div>
    </div>

</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Date of Birth <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
            <input type="date" class="form-control" name="data[ind_reg_birth]" placeholder="dd/mm/yyyy" value="" required>

        <div class="invalid-feedback">
            Please enter a valid birth date.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Nationality <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Turkish" name="data[ind_reg_nationality]" required>
        <div class="invalid-feedback">
            Please enter a valid nationality.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"><strong>Address <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control"  placeholder="Caferağa Mahallesi, Dr. Esat Işık Cd. " name="data[ind_reg_adress1]" required>
        <small class="form-text text-muted">Street Address</small>
        <div class="invalid-feedback">
            Please enter a valid adress.
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="D:68, 34710 Kadıköy/İstanbul" name="data[ind_reg_adress2]">
        <small class="form-text text-muted">Street Address Line 2</small>
    </div>
</div>

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputState">Country <span class="text-danger">*</span></label>

                <label>
                    <select class="input-medium bfh-countries form-control" data-countryList="US,AG,AU"
                            data-country="TR" name="data[ind_reg_country]" required>
                    </select>
                    <div class="invalid-feedback">
                        Please select a country.
                    </div>
                </label>

            </div>
            <div class="form-group col-md-4">
                <label for="inputCity">City <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Istanbul" name="data[ind_reg_city]" required>
                <div class="invalid-feedback">
                    Please enter a valid city.
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip <span class="text-danger">*</span></label>
                <input type="text" class="form-control input-medium bfh-phone" data-format="ddddd" placeholder="34710" name="data[ind_reg_zip]" required>
                <div class="invalid-feedback">
                    Please enter a valid zip.
                </div>
            </div>
        </div>

    </div>

</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Name Of School <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Kadıköy Anatolian High School" name="ind_reg_name_of_school" required>
        <div class="invalid-feedback">
            Please enter a valid school name.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"><strong>School Address <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control"  placeholder="Caferağa Mahallesi, Dr. Esat Işık Cd. " name="data[ind_reg_school_adress1]" required>
        <small class="form-text text-muted">Street Address</small>
        <div class="invalid-feedback">
            Please enter a valid adress.
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="D:68, 34710 Kadıköy/İstanbul" name="data[ind_reg_school_adress2]">
        <small class="form-text text-muted">Street Address Line 2</small>
    </div>
</div>

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputState">Country <span class="text-danger">*</span></label>

                <label>
                    <select class="input-medium bfh-countries form-control" data-countryList="US,AG,AU"
                            data-country="TR" name="data[ind_reg_school_country]" required>
                    </select>
                    <div class="invalid-feedback">
                        Please select a country.
                    </div>
                </label>

            </div>
            <div class="form-group col-md-4">
                <label for="inputCity">City <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Istanbul" name="data[ind_reg_school_city]" required>
                <div class="invalid-feedback">
                    Please enter a valid city.
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip <span class="text-danger">*</span></label>
                <input type="text" class="form-control input-medium bfh-phone" data-format="ddddd" placeholder="34710" name="data[ind_reg_school_zip]" required>
                <div class="invalid-feedback">
                    Please enter a valid zip.
                </div>
            </div>
        </div>

    </div>

</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Graduation Year <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="number" min="2017" max="2050" class="form-control" placeholder="Turkish" name="data[ind_reg_graduation_year]" value="2017" required>
        <div class="invalid-feedback">
            Please enter a valid graduation year.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Number <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="tel" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="ind_reg_contact_phone" required>
        <div class="invalid-feedback">
            Please enter a valid phone number.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Email <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="email" class="form-control" placeholder="example@example.com" name="ind_reg_contact_mail" required>
        <div class="invalid-feedback">
            Please enter a valid email.
        </div>
    </div>
</div>

<br>
<hr>
<strong>Please state the conferences that you've attended.
    If you are a first timer you may omit the question but please bear in mind that your acceptance,
    committee and delegation allocation will be concluded in accordance with your experience. <span class="text-danger">*</span>
</strong>
<hr>

<div class="form-group row" id="expandable">
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

<div class="form-group row" id="expandable">
    <div class="col-sm-3">
        <select class="form-control"  name="data[ind_reg_confs][conf_position][]" required>
            <option value="">Please Select...</option>
            <option value="Delegate">Delegate</option>
            <option value="Organiser">Organiser</option>
            <option value="Student Officer">Student Officer</option>
            <option value="ICC/ICJ">ICC/ICJ</option>
            <option value="Observer">Observer</option>
        </select>
        <div class="invalid-feedback">
            Please write a position.
        </div>
    </div>

    <div class="col-sm-2">
        <input type="number" class="form-control" placeholder="2017" min="2000" max="2050" name="data[ind_reg_confs][conf_year][]" required>
        <div class="invalid-feedback">
            Please enter a valid year.
        </div>
    </div>

    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="e.g. KALMUN" name="data[ind_reg_confs][conf_name][]" required>
        <div class="invalid-feedback">
            Please enter a valid name.
        </div>
    </div>

    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="Delegate of United Kingdom" name="data[ind_reg_confs][conf_position_held][]" required>
        <div class="invalid-feedback">
            Please enter a valid position.
        </div>
    </div>

    <div class="col-sm-1">
        <div class="input-group-btn">
            <button class="btn btn-success add" type="button"  onclick="education_fields();"> <span class="fa fa-plus" aria-hidden="true"></span> </button>
        </div>
    </div>

</div>
<div id="education_fields">
</div>

<br>
<hr>
<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Please state your top three committee preferences in decreasing order. Your application will be evaluated accordingly to this section, but the Secretariat does not guarantee your assignment to be in accordance with your preferences at all times. <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <div class="form-check row">
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="The General Assembly" >
            <label class="form-check-label" for="">The General Assembly</label>
            <br>
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="UN Security Council" >
            <label class="form-check-label" for="">UN Security Council</label>
            <br>
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="Office of the Special Adviser on Africa (OSAA)" >
            <label class="form-check-label" for="">Office of the Special Adviser on Africa (OSAA)</label>
            <br>
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="Historical Committee" >
            <label class="form-check-label" for="">Historical Committee</label>
            <br>
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="Economic and Social Council (ECOSOC)" >
            <label class="form-check-label" for="">Economic and Social Council (ECOSOC)</label>
            <br>
            <input type="checkbox" class="form-check-input" name="data[ind_reg_committee][]" value="Historical Joint Crisis Cabinets (HJCC)" >
            <label class="form-check-label" for="">Historical Joint Crisis Cabinets (HJCC)</label>
            <br>

            <div class="invalid-feedback">
                Please select a committee.
            </div>
        </div>


    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Motivational Letter: Please indicate your past MUN experiences, eligibility and motivation for attending KALMUN 2018 as a participant in the Special Committees. (max. 350 words) <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <label>
            <textarea class="form-control" rows="8" cols="250" maxlength="350" name="data[ind_reg_motv_letter]" required></textarea>
            <div class="invalid-feedback">
                Please write an essay.
            </div>
        </label>
        <div class="invalid-feedback">
            Please write a letter.
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Please write an extensively detailed essay on a selected agenda item of the preferred committee of yours. (max. 350 words) <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <label>
            <textarea class="form-control" rows="8" cols="250" maxlength="350" name="data[ind_reg_essay]" required></textarea>
            <div class="invalid-feedback">
                Please write an essay.
            </div>
        </label>

    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Special Conditions.</strong></label>

    <div class="col-sm-9">
        <label>
            <input type="text" class="form-control" maxlength="250" name="data[ind_reg_spec_cond]">
        </label>
    </div>
</div>









<input type="hidden" name="application_type" value="2">

<script src="/inc/js/jquery-3.3.1.min.js"></script>
<script>
    var room = 1;
    function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<div class="form-group row" id="expandable">     <div class="col-sm-3">         <select class="form-control"  name="data[ind_reg_confs][conf_position][]" required>             <option value="">Please Select...</option>             <option value="Delegate">Delegate</option>             <option value="Organiser">Organiser</option>             <option value="Student Officer">Student Officer</option>             <option value="ICC/ICJ">ICC/ICJ</option>             <option value="Observer">Observer</option>         </select><div class="invalid-feedback">Please write a position.</div>     </div>     <div class="col-sm-2">         <input type="number" class="form-control" placeholder="2017" min="2000" max="2050" name="data[ind_reg_confs][conf_year][]" required>         <div class="invalid-feedback">             Please enter a valid year.         </div>     </div>     <div class="col-sm-3">         <input type="text" class="form-control" placeholder="e.g. KALMUN" name="data[ind_reg_confs][conf_name][]" required>         <div class="invalid-feedback">             Please enter a valid name.         </div>     </div>     <div class="col-sm-3">         <input type="text" class="form-control" placeholder="Delegate of United Kingdom" name="data[ind_reg_confs][conf_position_held][]" required>         <div class="invalid-feedback">             Please enter a valid position.         </div>     </div>     <div class="col-sm-1">         <div class="input-group-btn">            <button class="btn btn-danger" type="button" onclick="remove_education_fields('+room+');"> <span class="fa fa-minus" aria-hidden="true"></span> </button>         </div>     </div> </div>';

        objTo.appendChild(divtest)
    }
    function remove_education_fields(rid) {
        $('.removeclass'+rid).remove();
    }

</script>