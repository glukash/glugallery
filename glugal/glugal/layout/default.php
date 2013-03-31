<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="pl" xml:lang="pl" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>GluGallery Backend <?php echo $gRootUrl; ?> <?php echo $gRoot; ?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Description" content="Opis" />
    <meta name="Keywords" content="keyword1,keyword2" />
    <meta name="classification" content="wesela imprezy bankiety" />
    <meta name="abstract" content="Zespół na wesele" />
    <meta name="robots" content="all,index,follow" />
    <meta name="revisit-after" content="2 days" />
    <base href="<?php echo $gRootUrl; ?>" />
    <script type="text/javascript">
    //<![CDATA[
        var gRootUrl = '<?php echo $gRootUrl; ?>';
    //]]>
    </script>
    <link type="image/x-icon" rel="Shortcut icon" href="<?php echo $gRootUrl; ?>favicon.ico" />
    <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $gAppUrl; ?>gluf/css/reset.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $gAppUrl; ?>gluf/css/classes.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $gAppUrl; ?>css/screen.css" />

    <!--<link href="http://fonts.googleapis.com/css?family=Comfortaa:400,700|Yeseva+One|Average+Sans|Signika+Negative:400,700|Inconsolata:400,700|Andika|Amarante|Righteous&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css" />-->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <!--<script type="text/javascript" src="/gluf/js/jquery-1.9.1.js"></script>-->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>-->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>-->

    <script type="text/javascript" src="<?php echo $gAppUrl; ?>js/jquery-ui-1.10.1.custom.min.js"></script>
    <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $gAppUrl; ?>css/smoothness/jquery-ui-1.10.1.custom.min.css" />

    <script type="text/javascript" src="<?php echo $gAppUrl; ?>js/colorbox/jquery.colorbox-min.js"></script>
    <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $gAppUrl; ?>js/colorbox/example3/colorbox.css" />

    <!--<script type="text/javascript" src="/gluf/js/jquery.marquee/lib/jquery.marquee.min.js"></script>-->
    <!--<link type="text/css" rel="stylesheet" media="screen" href="/gluf/js/jquery.marquee/css/jquery.marquee.css" />    -->

    <!--<script type="text/javascript" src="/gluf/js/jquery.cycle.all.js"></script>-->
    <script type="text/javascript" src="<?php echo $gAppUrl; ?>js/jquery.cookie.js"></script>
    <!--<script type="text/javascript" src="/gluf/js/swfobject.js"></script>-->
    <script type="text/javascript" src="<?php echo $gAppUrl; ?>gluf/js/gluflib.js"></script>
    <script type="text/javascript" src="<?php echo $gAppUrl; ?>gluf/js/glufcore.js"></script>
    <script type="text/javascript" src="<?php echo $gAppUrl; ?>js/glugal.js"></script>
    <?php gHead($qHead); ?>
    <!--[if IE 6]>
    <script type="text/javascript">
    //<![CDATA[
        $(window).load(function(){
            alert ("Twoja przeglądarka jest przestarzała!\nStrona nie będzie wyświetlona poprawnie!");
        });
    //]]>
    </script>
    <![endif]-->
</head>
<body>
    <div id="loader-wrapper">
        <div id="loader-message"></div>
        <img src="<?php echo $gAppUrl; ?>gluf/img/loaders/horizontal.gif" alt="..." />
    </div>
    <div id="wrapper">
        <div id="header">
        </div>
        <div id="main">
            <div id="main-content" class="ajax-container">
                <?php include view(); ?>
            </div>
        </div>
        <div id="main-footer">
        </div>
    </div>
    <?php include element('glumsg'); ?>
</body>
</html>
