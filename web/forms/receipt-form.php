 <?php
  // require("../../assets/inc/password_protect.php");
  require(__DIR__ . '/../../inc/password_protect.php');
  ?>


 <!doctype html>
 <?php
  require_once("../../inc/db-connection.php");

  $query = "select user.* from user order by id desc";
  $user_result = $conn->query($query) or die($conn->error);
  $total_rows = $user_result->num_rows;

  $maxcredit = 100;
  ?>

 <html lang="en">

 <head>
   <?php require("../../inc/header.php"); ?>
 </head>

 <body>

   <!-- navbar here      -->
   <?php require("../../inc/navbar.php"); ?>
   <!-- navbar end here      -->
   <!-- body start here      -->

   <form method="post" action="receipt-pdf-generator.php" class="form-horizontal container-fluid ">
     <fieldset>

       <!-- Form Name -->
       <legend>
         <center>Receipt Form</center>
       </legend>




       <!-- Select Resident -->
       <div class="form-group">
         <label class="col-md-4 control-label" for="name">Name</label>
         <div class="col-md-2">
           <select id="name" name="name" class="form-control" required>
             <!-- get residents array from db -->
             <?php while ($row = $user_result->fetch_assoc()) { ?>
               <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
             <?php } ?>
           </select>
         </div>
       </div>
       <!-- date-->
       <div class="form-group">
         <label class="col-md-4 control-label" for="date">Date</label>
         <div class="col-md-2">
           <input id="date" name="date" placeholder="date" class="form-control input-md datepicker" type="text">
           <span class="help-block">mm/dd/yyyy</span>
         </div>
       </div>
       <hr>

       <!-- Description -->
       <div class="form-group">
         <label class="col-md-4 control-label" for="description">Decribribe The Purchase &amp; Purpose*</label>
         <div class="col-md-5">
           <textarea class="form-control" id="description" name="description" placeholder="Example: Materials for Class - paper, pens, and pencils " required></textarea>
         </div>
       </div>
       <hr>

       <!-- receipt amount-->
       <div class="form-group">
         <label class="col-md-4 control-label" for="amount">Receipt Amount</label>
         <div class="col-md-2">
           <div class="input-group">
             <span class="input-group-addon">$</span>
             <input id="amount" name="amount" class="form-control" style="z-index: 1;" size="6" maxlength="6" placeholder="" required="" type="number">
           </div>

         </div>
       </div>
       <hr>


       <!-- credit or donation or both -->
       <div class="form-group">
         <label class="col-md-4 control-label" for="checkboxes">Would You Like To:</label>
         <div class="col-md-4">
           <div class="checkbox">
             <label for="checkboxes-0">
               <input name="amount_option" class=" amount_option" id="checkboxes-0" value="1" type="radio">
               Submit Entire Amount As Resident Credit <br><small><i>(receipts over $<?php echo "$maxcredit need prior approval"; ?>)</i></small>
             </label>
           </div>
           <div class="checkbox">
             <label for="checkboxes-1">
               <input name="amount_option" class=" amount_option" id="checkboxes-1" value="2" type="radio">
               Donate The Entire Amount
             </label>
           </div>
           <div class="checkbox">
             <label for="checkboxes-2">
               <input name="amount_option" class=" amount_option" id="checkboxes-2" value="3" type="radio">
               Both Credit and Donation
             </label>
           </div>
         </div>
       </div>




       <div class="container-fluid" style="display:none;" id="credit_donation_div">


         <!-- credit amount-->
         <div class="form-group">
           <label class="col-md-4 control-label" for="credit">Resident Credit Amount</label>
           <div class="col-md-2">
             <div class="input-group">
               <span class="input-group-addon">$</span>
               <input id="credit" name="credit" class="form-control amount_credit_donation" placeholder="" type="number">
             </div>

           </div>
         </div>

         <!-- donation amount-->
         <div class="form-group">
           <label class="col-md-4 control-label" for="prependedtext">Donation Amount</label>
           <div class="col-md-2">
             <div class="input-group">
               <span class="input-group-addon">$</span>
               <input id="donation" name="prependedtext" class="form-control amount_credit_donation" placeholder="" required="" type="number">
             </div>

           </div>
         </div>
       </div>

       <hr>
       <!-- File Button - use dropzone.js and style for upload-->
       <div class="form-group">
         <label class="col-md-4 control-label" for="filebutton">Upload Receipt*<br><small>formats accepted:<br>jpg, png</small></label>
         <div class="col-md-4 " class="fallback">
           <!--<input id="filebutton" accept="image/*" name="filebutton" class="input-file" type="file">-->
         </div>
       </div>
       <div class="dropzone dz-clickable" id="myDrop">
         <div class="dz-default dz-message" data-dz-message="">
           <span>
             <h3>Snap a pic of your receipt and..</h3>
           </span>
           <span>
             <h2>Touch or Drop image here</h2>
           </span>
         </div>
       </div>
     </fieldset>

     <button class='btn btn-primary' id='submitbtn' type="button">Submit</button>
   </form>

   <hr>

   <!--<script src="../../assets/js/vendor/dropzone.js"></script>
<script src="../../assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/vendor/bootstrap.min.js"></script>
<script src="../../assets/js/vendor/bootstrap.min.js"></script>-->

   <script src="../../assets/js/vendor/jquery-1.11.2.min.js"></script>
   <script src="../../assets/js/vendor/dropzone.js"></script>
   <script src="../../assets/js/vendor/bootstrap.min.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="../../assets/js/main.js"></script>

   <center>
     <?php require("../../assets/inc/footer.php"); ?> </center>

 </body>

 </html>
 <!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->