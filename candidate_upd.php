<script>
    // function to perform validations
    function checkForm() {
        var fname = document.forms["candidate_upd"]["fname_upd"].value;
        var dob = new Date(document.forms["candidate_upd"]["dob_upd"].value);
        var email = document.forms["candidate_upd"]["email_upd"].value;
        var phnum = document.forms["candidate_upd"]["phnum_upd"].value;

        /* // checking for digits in full name
        if (!(/^[A-Za-z\s]+$/.test(fname))) {
            window.alert("Full name is invalid");
            return false;
        } */

        //calculate month difference from current date in time  
        var month_diff = Date.now() - dob.getTime();
        //convert the calculated difference in date format
        var age_dt = new Date(month_diff);
        //extract year from date
        var year = age_dt.getUTCFullYear();
        //now calculate the age of the user
        var age = Math.abs(year - 1970);

        // checking for age, valid age is 18 to 60
        if (!(/^\d{2}$/.test(age)) || age > 60 || age < 18) {
            window.alert("age is invalid");
            return false;
        }

        // checking validity of email
        if (!(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test(email))) {
            window.alert("email is invalid");
            return false;
        }

        // checking for telephone or mobile phone number
        if (!(/^\d{8,10}$/.test(phnum))) {
            window.alert("phone number is invalid");
            return false;
        }

        return true;
    }
</script>

<!-- modal update -->
<div class="modal fade" id="modal_update<?php echo $row["candidate_id"]; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Candidate Update form: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container p-5 my-2 border">
                    <h2>Update your details here:</h2><br>
                    <form name="candidate_upd" onsubmit="return checkForm()" action="candidate_upd_query.php" method="POST">

                        <div class="form-group">
                            <label for="fname_upd" class="form-label">Full Name: </label>
                            <input type="text" class="form-control" id="fname_upd" name="fname_upd" value="<?php echo $row["candidate_fullname"]; ?>" required>
                        </div>
                        <br>

                        <div class="form-inline">
                            <label for="dob_upd" class="form-label">Date of Birth: </label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dob_upd" name="dob_upd" value="<?php echo $row["candidate_dob"]; ?>" required>
                            </div>
                        </div>
                        <br>

                        <div class="form-check">
                            <label for="gender_upd" class="form-label">Gender: </label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" <?php if ($row["candidate_gender"] == "Male") echo "checked"; ?> value="Male">Male
                                <label class="form-check-label" for="gender_upd"></label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" <?php if ($row["candidate_gender"] == "Female") echo "checked"; ?> value="Female">Female
                                <label class="form-check-label" for="gender_upd"></label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" <?php if ($row["candidate_gender"] == "Others") echo "checked"; ?> value="Others">Others
                                <label class="form-check-label" for="gender_upd"></label>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="address_upd" class="form-label">Address: </label>
                            <textarea type="text" class="form-control" rows="5" cols="33" id="address_upd" name="address_upd" required><?php echo $row["candidate_address"]; ?></textarea>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="phnum_upd" class="form-label">Phone number: (+91) </label>
                            <input type="tel" class="form-control" id="phnum_upd" name="phnum_upd" value="<?php echo $row["phnum"]; ?>" maxlength="10" pattern="[1-9]{1}[0-9]{9}" title="Please enter a valid 10 digits contact number" required>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="email_upd" class="form-label">Email address: </label>
                            <input type="email" class="form-control" id="email_upd" name="email_upd" aria-describedby="emailHelp" value="<?php echo $row["candidate_email"]; ?>" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <br>

                        <div class="form-inline">
                            <label for="workexp_upd" class="form-label">Experience (in years): </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="workexp_upd" name="workexp_upd" value="<?php echo $row["experience_in_years"]; ?>" required>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="qualif_upd" class="form-label">Qualifications: </label>
                            <input type="text" class="form-control" id="qualif_upd" name="qualif_upd" required>
                        </div>
                        <br>

                        <input type="hidden" id="cid" name="cid" value="<?php echo $row["candidate_id"]; ?>">

                        <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>