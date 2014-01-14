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
    <footer>

       <div id="copyright"> &copy; 2012 Nemean </div>
    </footer>
 
<?php if ($session->isAuthorized(array('Developer', 'Crew'))) : ?>
        <a id="toAdminBtn" href="admin.php">Adminpanel</a>
    <?php endif; ?>

</body>


</html>