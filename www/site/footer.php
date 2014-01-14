<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 29.06.12
 * Time: 13:29
 * To change this template use File | Settings | File Templates.
 */
?>

        <div class="push"></div>
    </div>
    <footer><br>

       <div id="navfooter"> <a href="?m=articles&act=view&artID=37"> Kontakt</a> - <a href="?m=articles&act=view&artID=36">Om oss</a> - <a href="https://www.facebook.com/nemeanlan"> Facebook </a> - <a href="https://twitter.com/NemeanLAN"> Twitter </a> - <a href=""> Sponsorer </a> </div>
      <br> <div id="copyright"> &copy; 2012 Nemean </div>
    </footer>

<?php if ($session->isAuthorized(array('Developer', 'Crew'))) : ?>
        <a id="toAdminBtn" href="admin.php">Adminpanel</a>
    <?php endif; ?>

</body>


</html>