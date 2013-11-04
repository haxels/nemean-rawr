<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Nemean - Administrasjonspanel</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <link href="resources/site/html/admin/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="resources/site/html/new/css/map.css" rel="stylesheet" type="text/css" />
        <link href="resources/site/html/admin/css/dt.css" rel="stylesheet" type="text/css" />
        <link href="resources/site/html/admin/css/main.css" rel="stylesheet" type="text/css" />


        <!-- jQuery Javascript -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="resources/site/html/admin/js/jquery.dataTables.js"></script>
        <script src="../plugins/ckeditor/ckeditor.js"></script>
        <script src="../plugins/ckfinder/ckfinder.js"></script>

        <!-- Bootstrap Javascript -->

        <script src="resources/site/html/admin/js/bootstrap.js"></script>

        <!-- Nemean Javascript -->
        <script src="resources/site/html/admin/js/jquery.confirm.js"></script>
        <script src="resources/site/html/admin/js/Nemean.js"></script>
        <script src="resources/site/html/admin/js/main.js"></script>
        <script src="resources/site/html/admin/js/user.js"></script>
        <!--<script src="resources/site/html/admin/js/user.js"></script>-->

    </head>
    <body>

        <div class="navbar">
            <div class="navbar-inner">
            <a class="brand">Administrasjonspanel</a>


        <ul class="nav">

            <li <?php echo (!isset($_GET['m']) || $_GET['m'] == '') ? 'class="active"' : '';?>><a href="?m=">Start</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'articles') ? 'class="active"' : '';?>><a href="?m=articles">Artikler</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'users') ? 'class="active"' : '';?>><a href="?m=users">Brukere</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'compos') ? 'class="active"' : '';?>><a href="?m=compos">Compoer</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'reservations') ? 'class="active"' : '';?>><a href="?m=reservations">Reservasjoner</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'presentation') ? 'class="active"' : '';?>><a href="?m=presentation">Presentasjoner</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'sponsors') ? 'class="active"' : '';?>><a href="?m=sponsors">Sponsorer</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'menu') ? 'class="active"' : '';?>><a href="?m=menu">Meny</a></li>
            <li <?php echo (isset($_GET['m']) && $_GET['m'] == 'kiosk') ? 'class="active"' : '';?>><a href="?m=kiosk">Kiosk</a></li>
            <li><a href="?mAct=logout">Logg ut</a></li>

        </ul>
            </div>
        </div>

        <section class="content">
