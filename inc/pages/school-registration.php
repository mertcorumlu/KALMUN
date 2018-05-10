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


<h1>KALMUN 2018 - School Registration Form I</h1>
<p>You may submit your school's delegation application to KALMUN 2018 by filling out Form I below.
    Please see kalmun.org/information, our information page regarding the applications before concluding your application.
    By filling out this form, you will automatically agree to our terms and conditions.</p>

<hr>
<br>


<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Name Of School <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Kadıköy Anatolian High School" name="school_reg_name_of_school" required>
        <div class="invalid-feedback">
            Please enter a valid school name.
        </div>
    </div>
</div>

</br>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"><strong>Address Of School <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control"  placeholder="Caferağa Mahallesi, Dr. Esat Işık Cd. " name="data[school_reg_adress1]" required>
        <small class="form-text text-muted">Street Address</small>
        <div class="invalid-feedback">
            Please enter a valid adress.
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="inputAddress" class="col-sm-3 col-form-label"></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="D:68, 34710 Kadıköy/İstanbul" name="data[school_reg_adress2]">
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
                            data-country="TR" name="data[school_reg_country]" required>
                    </select>
                    <div class="invalid-feedback">
                        Please select a country.
                    </div>
                </label>

            </div>
            <div class="form-group col-md-4">
                <label for="inputCity">City <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Istanbul" name="data[school_reg_city]" required>
                <div class="invalid-feedback">
                    Please enter a valid city.
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip <span class="text-danger">*</span></label>
                <input type="text" class="form-control input-medium bfh-phone" data-format="ddddd" placeholder="34710" name="data[school_reg_zip]" required>
                <div class="invalid-feedback">
                    Please enter a valid zip.
                </div>
            </div>
        </div>

    </div>

</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Email <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="email" class="form-control" placeholder="example@example.com" name="school_reg_contact_mail" required>
        <div class="invalid-feedback">
            Please enter a valid email.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Number <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="tel" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="school_reg_contact_phone" required>
        <div class="invalid-feedback">
            Please enter a valid phone number.
        </div>
    </div>
</div>

<br>
<hr>


<h1>Advisor Information</h1>
<p>Information regarding MUN-Directors</p>

<hr>
<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Number of Advisors Attending <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <label>
            <input type="number" class="form-control"  min="1" max="30" value="1" name="data[school_reg_num_of_advisors]" required>
        </label>
        <div class="invalid-feedback">
            Please enter a valid advisor number.
        </div>
        <small>The delegation fee covers only one advisor's participation fee.</small>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Full Name of Advisor <span class="text-danger">*</span></strong></label>

    <div class="col-sm-4">
        <input type="text" class="form-control" placeholder="Dilek" name="data[school_reg_advisor_name]" required>
        <small>Name</small>
        <div class="invalid-feedback">
            Please enter a valid advisor name.
        </div>
    </div>
    <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Karagül" name="data[school_reg_advisor_last_name]" required>
        <small>Last Name</small>
        <div class="invalid-feedback">
            Please enter a valid advisor last name.
        </div>
    </div>


</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Phone of Advisor <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control input-medium bfh-phone" placeholder="555 444 33 22" data-format="ddd ddd dd dd" name="data[school_reg_advisor_phone]" required>
        <div class="invalid-feedback">
            Please enter a valid advisor phone.
        </div>
    </div>



</div>


<br>
<hr>


<h1>Head Delegate Information</h1>
<p>Information regarding the Head of Delegation</p>

<hr>
<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Full Name <span class="text-danger">*</span></strong></label>

    <div class="col-sm-4">
        <input type="text" class="form-control" placeholder="Arda" name="data[school_reg_header_name]" required>
        <small>Name</small>
        <div class="invalid-feedback">
            Please enter a valid header name.
        </div>
    </div>

    <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Karasulu" name="data[school_reg_header_last_name]" required>
        <small>Last Name</small>
        <div class="invalid-feedback">
            Please enter a valid header last name.
        </div>
    </div>




</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Email <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="email" class="form-control" placeholder="example@example.com" name="data[school_reg_header_email]" required>
        <div class="invalid-feedback">
            Please enter a valid header phone.
        </div>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Contact Number <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <input type="text" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="data[school_reg_header_phone]" required>
        <div class="invalid-feedback">
            Please enter a valid header phone.
        </div>
    </div>
</div>

<br>
<hr>


<h1>Delegation Information</h1>
<p>Details regarding the delegation</p>

<hr>
<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Delegation Size Preference <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <label>
            <select class="form-control" name="data[school_reg_size_pref]" required>
                <option value="">Please Select...</option>
                <option value="4">4</option>
                <option value="8">8</option>
                <option value="12">12</option>
                <option value="16">16</option>
                <option value="20">20</option>
            </select>
            <div class="invalid-feedback">
                Please select a size preference.
            </div>
        </label>
    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Do you require a visa ? <span class="text-danger">*</span></strong></label>

    <div class="col-sm-9">
        <div class="form-check row">
            <input type="radio" class="form-check-input" name="data[school_reg_visa]" value="yes" required>
            <label class="form-check-label" for="">Yes</label>
            <br>
            <input type="radio" class="form-check-input" name="data[school_reg_visa]" value="no" required>
            <label class="form-check-label" for="">No</label>
            <div class="invalid-feedback">
                Please select a visa state.
            </div>
        </div>


    </div>
</div>

<br>

<div class="form-group row">
    <label for="" class="col-sm-3 col-form-label"><strong>Please indicate your top three country preferences in decreasing order. Please state your choices accordingly with our provisional Country Matrix.</strong></label>

    <div class="col-sm-9">
        <label>
            <textarea class="form-control" rows="8" cols="250" maxlength="300" name="data[school_reg_pref]"></textarea>
        </label>
    </div>
</div>

<input type="hidden" name="application_type" value="1">
