<?php defined('BASEPATH') OR  exit('No direct script access allowed'); ?>
<div id="I-M-LS-W" align="center"><div class="hidden" id="LOADING-CONT"><i class="LOAD-ICON i_f_setting"></i></div><div id="FORM-CONT">
<h2 id="HEAD-TOP-TXT">Add Operator</h2><?php if(isset($message)){echo "<div class=\"message\">$message</div>";} ?><form id="MoveInForm" method="POST" action="<?php echo base_url(); ?>admins/create" data-csrf="xJRtIklD">
<div align="right">
<div class="Form-Input" align="left"><label class="InputIcon i_f_user" for="PAT-NM"></label><input placeholder="Name" id="PAT-NM" type="text"  required="" name="name" value="<?php echo set_value("name"); ?>" /></div>
<br />
<div class="Form-Input" align="left"><label class="InputIcon i_f_shield" for="PAT-LI"></label><input placeholder="Username" id="PAT-LI" type="text"  required="" name="username" value="<?php echo set_value("username"); ?>" /></div>
<br />
<div class="Form-Input" align="left"><label class="InputIcon i_f_shield" for="PAT-PASS"></label><input placeholder="Password" id="PAT-PASS" type="password" required="" name="password" value="<?php echo set_value("password"); ?>" /></div>
<br />
<div class="Form-Input" align="left"><label class="InputIcon i_f_mail" for="PAT-EMAIL"></label><input placeholder="Email" id="PAT-EMAIL" type="email" name="email" value="<?php echo set_value("email"); ?>" /></div>
<br />
<div class="Form-Input" align="left"><label class="InputIcon i_f_mobile" for="PAT-PHONE"></label><input placeholder="Phone" id="PAT-PHONE" type="tel" name="phone" value="<?php echo set_value("phone"); ?>" /></div>
<br />
<div class="Form-Input" align="left"><label class="InputIcon i_f_hammer" for="PAT-PHONE"></label><select id="PAT-A_RIGHTS" style="font-size:13px; height:30px;" name="rights">
        <option selected="true" value="0">Choose</option>
        <option value="1">Read/Write/Update/Delete/Create Operator</option>
        <option value="2">Read+Write+Update+Delete</option>
        <option value="3">Read+Write+Update</option>
        <option value="4">Read+Write</option>
        <option value="5">Read</option>
    </select></div>
<script type="text/javascript">document.getElementById("PAT-A_RIGHTS").value ="<?php echo set_value("rights",0); ?>";</script>
<br />
<div class="changeWay" id="changeWay" align="left"><?php echo validation_errors(); ?></div><button>Go</button>
</div>
</form></div>
</div>