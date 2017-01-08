<?php echo validation_errors("<div style='background:red; color:#fff; padding:20px;'>","</div>"); ?>
<fieldset>
    <legend>Please Add a firm and root user before using the software</legend>
<form action="<?php echo base_url()."install/install"; ?>" method="post">
    <fieldset>
        <legend>Firm Details</legend>
        <label>Firm Name
        <input name="firmname" minlength="3" required />
    </label>
    <label>Firm Contact
        <input name="firmcontact" />
    </label>
        <p>
    <label>Firm Address
        <textarea name="firmadd"></textarea>
    </label>
        </p>
    </fieldset>
    <fieldset>
        <legend>Master User Account</legend>
        <label>
            Root User Name
            <input type="text" name="user_name" minlength="2" required />
        </label>
        <label>
            Root User Password
            <input type="password" name="user_pass" minlength="4" required />
        </label>
    </fieldset>

    <fieldset>
        <legend>Submit</legend>
        <button type="reset">Reset</button>
        <button type="submit">Submit</button>
    </fieldset>
</form>
</fieldset>