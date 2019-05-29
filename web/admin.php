 <?php require("../assets/inc/password_protect.php"); ?> 

<!doctype html>
<html lang="en">
<head>


<!-- header here      -->
 <?php require("../assets/inc/header.php"); ?> 
</head>
<body>

<!-- navbar here      -->
 <?php require("../assets/inc/navbar.php"); ?> 


<!-- navbar end here      -->
<!-- body start here      -->
<div>
  <center>
    <h1>Admin stuff</h1>
    <ul style="list-style:none">
      <li><a href="forms/residents-edit.php">add edit or remove residents</a></li>
      <li><a href="forms/work-form-pdf-export.php">export work submitted pdf's, and close month</a></li>
      <li><a href="forms/work-form-clear-db.php">clear db after exporting pdf's</a></li>
    </ul>
  </center>
</div>
<hr>

<!-- body end here      -->

<!-- footer here      -->
      <footer class="text-center">
 <?php require("../assets/inc/footer.php"); ?> 
      </footer>



<script src="../assets/js/vendor/jquery-1.11.2.min.js"></script>

<script src="../assets/js/vendor/bootstrap.min.js"></script>

</body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
