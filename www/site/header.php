<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 13:29
 * To change this template use File | Settings | File Templates.
 */
$session = $data['session'];
$menu    = $data['menu']->getMenu();
$submenu = $data['menu']->getSubMenu();
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"
      xmlns:og="http://opengraphprotocol.org/schema" xmlns="http://www.w3.org/1999/html"/>
<head>

    <title>Nemean</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"  />

    <link href="site/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="site/css/all.css" rel="stylesheet" type="text/css" />

    <!-- Internet Explorer HTML5 enabling script: -->
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--[if !IE]> -->
    <link href="site/css/stylesheet.css" rel="stylesheet" type="text/css" />
    <!-- <![endif]-->

    <!--[if lt IE 7]>
        <link href="site/css/IE6.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if lt IE 9]>
    <link href="site/css/IE_lt9.css" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!--[if gte IE 9]>
    <link href="site/css/stylesheet.css" rel="stylesheet" type="text/css" />
    <!-- <![endif]-->


    <!--[if !IE]> -->
    <style>

        .evenDivider a:hover
        {
             z-index: 99;
            transform: scale(1.5,1.5);
            -ms-transform: scale(1.5,1.5);
            -webkit-transform:scale(1.5,1.5);
            -moz-transform:scale(1.5,1.5);
            -o-transform: scale(1.5);
        }

    </style>
    <!-- <![endif]-->

    <link href="site/css/map.css" rel="stylesheet" type="text/css" />
    <link href="resources/img/kiosk/kiosk.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="favicon.ico" />


    <!-- jQuery Javascript -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
    <script type="text/javascript" src="site/js/jquery.reset.js"></script>
    <script type="text/javascript" src="site/js/visual.js"></script>
    <script type="text/javascript" src="img/kiosk/js/simpletip/jquery.simpletip-1.3.1.pack.js"></script>
    <script type="text/javascript" src="resources/img/kiosk/js/script.js"></script>

    <!-- Popup jQuery -->
    <script type="text/javascript" src="resources/img/kiosk/js/popup.js"></script>

    <script type="text/javascript">
        function sjekkBurger()
        {
            elmID = document.getElementById("rForts");
            elmBeID = document.getElementById("dialogBeskjed");
            if (document.getElementById("table_1") || document.getElementById("table_18"))
            {
                elmID.style.visibility = "visible";
                elmBeID.innerHTML = "Er du sikker på at du vil fortsette?";
            }
            else
            {
                elmID.style.visibility = "hidden";
                elmBeID.innerHTML = "Du må bestille en rett før du kan gå videre!";

            }
        }
    </script>

</head>
<body>
<!--[if lt IE 7]>
<div id="outdated" style=' clear: both; height: 59px; padding:0 0 0 15px; position: relative;'>
    Vi anbefaler deg å oppgradere til nyeste versjon av Internet Explorer. Selv Microsoft vil det, bare se her:
    <a href="http://www.ie6countdown.com">IE6</a><br />
    For å få tak i den nyeste versjonen klikk på bildet nedenfor:<br />
    <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
        <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0003_norwegian.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
    </a>
</div>
<![endif]-->

    <div class="wrapper">

        <header><a href="http://www.mamoz.no" style="position: absolute; right: 70px; top: 120px; width: 200px; height: 40px;"></a></header>

        <nav id="topmenu">
            <?php foreach ($menu as $item) : ?>
            <li><a href="<?php echo ($item->isParent()) ? '?pID='.$item->getMenuId().'&'.$item->getLink() : $item->getLink(); ?>"><?php echo $item->getLabel(); ?></a></li>
            <?php endforeach; ?>
            <?php if ($session->isAuthenticated()) : ?>
            <a href="?mAct=logout" class="lBtn" id="logoutBtn"><div><?php echo $session->getUser()->getFirstName(); ?></div></a>
            <?php else : ?>
            <a class="lBtn" id="loginBtn"><div>Logg inn</div></a>
            <?php endif; ?>
        </nav>





