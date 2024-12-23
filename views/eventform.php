<link href="<?php echo WEB_ROOT; ?>library/spry/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>

<link href="<?php echo WEB_ROOT; ?>library/spry/textareavalidation/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/textareavalidation/SpryValidationTextarea.js" type="text/javascript"></script>

<link href="<?php echo WEB_ROOT; ?>library/spry/selectvalidation/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo WEB_ROOT; ?>library/spry/selectvalidation/SpryValidationSelect.js" type="text/javascript"></script>


<style>
  /* Target the specific input field by its ID or within the div named 'tochange' */
  div[name="tochange"] input[type="date"] {
    padding-top: 0; /* Remove extra padding on top */
	padding-bottom:0px;
    height: auto; /* Ensure height is adequate */
    vertical-align: middle; /* Align the text vertically in the input field */
  }
</style>


<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Book Event</b></h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form role="form" action="<?php echo WEB_ROOT; ?>api/process.php?cmd=book" method="post">
    <div class="box-body">
      <div class="form-group">
        <label for="name">Name</label>
        <span id="sprytf_name">
          <select name="name" class="form-control input-sm">
            <option>--select user--</option>
            <?php
              $sql = "SELECT id, name FROM tbl_users";
              $result = dbQuery($sql);
              while ($row = dbFetchAssoc($result)) {
                extract($row);
            ?>
              <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
            <?php 
              }
            ?>
          </select>
          <span class="selectRequiredMsg">Name is required.</span>
        </span>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <span id="sprytf_address">
          <textarea name="address" class="form-control input-sm" placeholder="Address" id="address"></textarea>
          <span class="textareaRequiredMsg">Address is required.</span>
          <span class="textareaMinCharsMsg">Address must specify at least 10 characters.</span>	
        </span>
      </div>

      <div class="form-group">
        <label for="task">Task</label>
        <span id="sprytf_task">
          <textarea name="task" class="form-control input-sm" placeholder="Task" id="task"></textarea>
          <span class="textareaRequiredMsg">Task is required.</span>
          <span class="textareaMinCharsMsg">Task must specify at least 10 characters.</span>	
        </span>
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <span id="sprytf_phone">
          <input type="text" name="phone" class="form-control input-sm" placeholder="Phone number" id="phone">
          <span class="textfieldRequiredMsg">Phone number is required.</span>
        </span>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <span id="sprytf_email">
          <input type="text" name="email" class="form-control input-sm" placeholder="Enter email" id="email">
          <span class="textfieldRequiredMsg">Email ID is required.</span>
          <span class="textfieldInvalidFormatMsg">Please enter a valid email (user@domain.com).</span>
        </span>
      </div>

      <div class="form-group" name="tochange">
        <label for="rdate">Reservation Date</label>
        <span id="sprytf_rdate">
          <input type="date" name="rdate" class="form-control"  id ="new_change">
          <span class="textfieldRequiredMsg">Date is required.</span>
          <span id="dateError" style="display:none; color:red;">Previous date not possible.</span>
        </span>
      </div>

      <div class="form-group">
        <label for="rtime">Reservation Time</label>
        <span id="sprytf_rtime">
          <input type="text" name="rtime" class="form-control" placeholder="HH:mm">
          <span class="textfieldRequiredMsg">Time is required.</span>
          <span class="textfieldInvalidFormatMsg">Invalid time Format.</span>
        </span>
      </div>

      <div class="form-group">
        <label for="ucount">No of People</label>
        <span id="sprytf_ucount">
          <input type="text" name="ucount" class="form-control input-sm" placeholder="No of people">
          <span class="textfieldRequiredMsg">No of people is required.</span>
          <span class="textfieldInvalidFormatMsg">Invalid Format.</span>
        </span>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<!-- /.box -->

<script type="text/javascript">
  // Initialize Spry validations
  var sprytf_name = new Spry.Widget.ValidationSelect("sprytf_name");
  var sprytf_address = new Spry.Widget.ValidationTextarea("sprytf_address", {minChars:6, isRequired:true, validateOn:["blur", "change"]});
  var sprytf_task = new Spry.Widget.ValidationTextarea("sprytf_task", {minChars:6, isRequired:true, validateOn:["blur", "change"]});
  var sprytf_phone = new Spry.Widget.ValidationTextField("sprytf_phone", 'none', {validateOn:["blur", "change"]});
  var sprytf_email = new Spry.Widget.ValidationTextField("sprytf_email", 'email', {validateOn:["blur", "change"]});
  var sprytf_rdate = new Spry.Widget.ValidationTextField("sprytf_rdate", "none", {validateOn:["blur", "change"]});
  var sprytf_rtime = new Spry.Widget.ValidationTextField("sprytf_rtime", "time", {hint:"i.e 20:10", useCharacterMasking: true, validateOn:["blur", "change"]});
  var sprytf_ucount = new Spry.Widget.ValidationTextField("sprytf_ucount", "integer", {validateOn:["blur", "change"]});

  // Custom JavaScript for date validation
  document.addEventListener("DOMContentLoaded", function () {
      const rdateInput = document.querySelector('input[name="rdate"]');
      const dateError = document.getElementById("dateError");

      rdateInput.addEventListener("change", function () {
          const selectedDate = rdateInput.valueAsDate;
          const today = new Date();
          today.setHours(0, 0, 0, 0);

          if (!selectedDate) {
              dateError.style.display = "block";
              dateError.textContent = "Invalid date format.";
              rdateInput.value = "";
              return;
          }

          selectedDate.setHours(0, 0, 0, 0);

          if (selectedDate < today) {
              dateError.style.display = "block";
              dateError.textContent = "Previous dates are not allowed.";
              rdateInput.value = "";
          } else {
              dateError.style.display = "none";
              dateError.textContent = "";
          }
      });
  });
</script>
