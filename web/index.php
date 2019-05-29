 <?php require(__DIR__ . '/../inc/password_protect.php'); ?> 

<!doctype html>
<html lang="en">
<head>


<!-- header here      -->
 <?php require(__DIR__ . '/../inc/header.php'); ?> 
</head>
<body>

<!-- navbar here      -->
 <?php require(__DIR__ . '/../inc/navbar.php'); ?> 

<!-- body here      -->

  
    <div class="jumbotron">
      <div class="container">

          <div id="outer" style="width:100%"><div id="inner"><!-- center content  --> 
             <h1><center>Greenbriar Resident<br /><small>Information, Forms and Documents.</small></center></h1>
          </div></div><!-- end center content  --> 

      </div>
    </div>              



  <div id="main">
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4" "col-xs-2">
          <h2>Forms</h2>
          <p>More online forms, and printable forms to come, but for now we can now use this form for submitting hours. </p>
          <p><a class="btn btn-default" href="forms/work-form.php" role="button">Work Form &raquo;</a></p>
        </div>


        <div class="col-md-4" "col-xs-2">
          <h2>Submitted Hours Archive</h2>
          <p>The work form outputs a monthly pdf for easy book-keeping.</p>
          <p><a class="btn btn-default" href="files/?dir=archive/work-credit-submissions" role="button">Check it out &raquo;</a></p>

       </div>  

        <div class="col-md-4" "col-xs-2">
          <h2>Documents & Files</h2>
          <p>Important Greenbriar documents and archives. Take a look around, stay tuned, more files to come.</p>
          <p><a class="btn btn-default" href="files" role="button">Files and such &raquo;</a></p>
       </div>      
      </div>
      <hr>
    </div> <!-- /container -->     
  </div>


<!-- body end here      -->

<!-- footer here      -->
      <footer class="text-center">
 <?php require(__DIR__ . '/../inc/footer.php'); ?> 
      </footer>



<script src="/assets/js/vendor/jquery-1.11.2.min.js"></script>

<script src="/assets/js/vendor/bootstrap.min.js"></script>

</body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
