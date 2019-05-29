 <?php require("../../assets/inc/password_protect.php"); ?> 

<!doctype html>
<html lang="en">
<head>

<!-- header here      -->
 <?php require("../../assets/inc/header.php"); ?> 

</head>
<body>

<!-- navbar here      -->
 <?php require("../../assets/inc/navbar.php"); ?> 
 <!--<?php require("../../assets/inc/breadcrumbs.php"); ?>-->

<!-- body here      -->

<script src="../../assets/js/vendor/bootstrap.min.js"></script>


<?php

    // Include the DirectoryLister class
    require_once('resources/DirectoryLister.php');

    // Initialize the DirectoryLister object
    $lister = new DirectoryLister();

    // Restrict access to current directory
    ini_set('open_basedir', getcwd());

    // Return file hash
    if (isset($_GET['hash'])) {

        // Get file hash array and JSON encode it
        $hashes = $lister->getFileHash($_GET['hash']);
        $data   = json_encode($hashes);

        // Return the data
        die($data);

    }

    if (isset($_GET['zip'])) {

        $dirArray = $lister->zipDirectory($_GET['zip']);

    } else {

        // Initialize the directory array
        if (isset($_GET['dir'])) {
            $dirArray = $lister->listDirectory($_GET['dir']);
        } else {
            $dirArray = $lister->listDirectory('.');
        }

        // Define theme path
        if (!defined('THEMEPATH')) {
            define('THEMEPATH', $lister->getThemePath());
        }

        // Set path to theme index
        $themeIndex = $lister->getThemePath(true) . '/index.php';



        // Initialize the theme
        if (file_exists($themeIndex)) {
            include($themeIndex);
        } else {
            die('ERROR: Failed to initialize theme');
        }

    }
?>

<!-- body end here      -->








<script src="../../assets/js/vendor/jquery-1.11.2.min.js"></script>
<!---->

</body>
</html>
<!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
