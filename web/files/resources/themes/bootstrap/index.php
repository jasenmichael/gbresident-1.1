<!DOCTYPE html>

<html>

    <head>

        <title>Directory listing of <?php echo $lister->getListedPath(); ?></title>
        <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/img/folder.png">

        <!-- STYLES -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/css/style.css">

        <!-- SCRIPTS -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/directorylister.js"></script>

        <!-- FONTS
        <link rel="stylesheet" type="text/css"  href="//fonts.googleapis.com/css?family=Cutive+Mono"> -->

        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>

    </head>

    <body>

        <div id="page-navbar" class="navbar navbar-default">
            <div class="container">

                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>

                <p class="navbar-text">
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>



            </div>
        </div>

        <div class="list-group">

            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>

            <?php if($lister->getSystemMessages()): ?>
                <?php foreach ($lister->getSystemMessages() as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <ul id="directory-listing" class="nav nav-pills nav-stacked">

                <?php foreach($dirArray as $name => $fileInfo): ?>
                    <li data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
                        <a href="<?php echo $fileInfo['url_path']; ?>" data-name="<?php echo $name; ?>" class="list-group-item">
                            <div class="row">
                                <span class="file-name col-md-8 col-sm-auto col-xs-auto">
                                    <i class="fa <?php echo $fileInfo['icon_class']; ?> fa-lg"></i>
                                    <?php str_repeat('&nbsp;', 2); ?>
                                    <?php echo $name ; ?>
                                </span>

                                <span class="file-modified col-md-2 hidden-sm hidden-xs text-right">
                                    <?php echo $fileInfo['mod_time']; ?>
                                </span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

  
        <?php file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_footer.php"); ?>
        

    </body>

</html>
