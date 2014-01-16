<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 13:29
 * To change this template use File | Settings | File Templates.
 */
$session = $data['session'];
$menu = $data['menu'] -> getMenu();
$submenu = $data['menu'] -> getSubMenu();
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"
      xmlns:og="http://opengraphprotocol.org/schema" xmlns="http://www.w3.org/1999/html"/>
<head>

    <title>Nemean</title>
    
    <!-- jQuery Javascript -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="site/js/visual.js"></script>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"  />
    <link href="site/css/map.css" rel="stylesheet" type="text/css" />
    <link href="site/css/style.css" rel="stylesheet" type="text/css" />

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

    <div class="global-wrapper">

        <div class="login"> 
            <?php if ($session->isAuthenticated()) : ?>
            <a href="?mAct=logout" class="lBtn" id="logout-link"><div><?php echo $session -> getUser() -> getFirstName(); ?></div></a>
            <?php else : ?>
            <a href="" class="lBtn" id="login-link"><div>Logg inn</div></a>
            <?php endif; ?>
        </div>

        <section class="sidebar-left">
            <a href="index.php"><img src="site/img/logo.jpg"></a><!-- LOGO, 182px * 218px -->

            <nav>
                <?php
                    foreach ($menu as $item) { ?>
                <a class="menuitem" href="<?php echo ($item->isParent()) ? '?pID='.$item->getMenuId().'&'.$item->getLink() : $item->getLink(); ?>"><?php echo $item -> getLabel(); ?></a><br>
                <?php
                    if (isset($_GET['pID']) && $_GET['pID'] ==
                        $item->getMenuId()) {
                        foreach ($submenu as $subitem) { ?>
                            <a class="submenuitem" href="<?php echo
                            $subitem->getLink(); ?>&pID=<?php echo
                            $_GET['pID']; ?>"><?php echo $subitem ->
                                    getLabel(); ?></a><br>
                <?php
                        }
                    }


                    }
                ?>
                
            </nav>
            </section>

            <div class="content-right">
                <header>
                    <a class="headerpart-1" href=""> <!-- Part 1, Darkgreen. Link to information-page. Hover event not created yet. --> <!-- Divided into two columns -->
                        <div id="left-column">
                            <h3>Hvor?</h3>
                            <h5>Kyrksæterøra,
                            <br/>
                            Sør-Trøndelag</h5>
                            <h3>Når?</h3>
                            <h5>19. - 23. Februar 2014</h5>
                        </div>
    
                        <div id="right-column">
                            <!-- Using spans to make it easier in php, I think... -->
                            <h3>Pris?</h3>
                            <h5>Deltaker: <span class="pricetag">400,-</span></h5>
                            <h5>PGA: <span class="pricetag">500,-</span></h5>
                            <h5>Besøke: <span class="pricetag">150,-</span></h5>
                        </div>
                        <br style="clear:both;"/>
                        <!-- Force headerpart-1 to surround the two columns (floating divs, may not be nessesary, but since I'm cool...) --> </a>
                        <div class="triangle-1"></div>
                        <a class="headerpart-2" href="" id="registerBtn"> <!-- Part 2, Lightgreen. Link to registration-page. Hover event not created yet. --> <h3>Registrering</h3> </a>
                        <div class="triangle-2"></div>
                        <a class="headerpart-3" href="?pID=24&m=reservations"> <!-- Part 3, Darkgreen. Link to spacemap. Hover event not created yet. --> <h3 id="spacemap">Plasskart</h3> </a>
                    </header>

                    <?php foreach ($submenu as $item) : ?>
                    <!-- <li><a href="<?php echo $item->getLink(); ?>&pID=<?php echo $_GET['pID']; ?>"><?php echo $item->getLabel(); ?></a></li> -->
                    <?php endforeach; ?>






