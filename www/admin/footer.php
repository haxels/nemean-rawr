
</section>

<footer class="muted container"><hr> Nemean &copy; 2006 - <?php echo date("Y", time()); ?></footer>

<div id="imagePicker"><h4>Bildevelger</h4>
    <hr />
    <?php
        $fileBrowser = new FileBrowser('resources/img/articles/');
        $fileBrowser->view();
    ?>
    <br />
    <button id="uploadBtn">Last opp</button>
    <?php var_dump($_GET); ?>
</div>

<div id="notify">
    <p id="notifyMsg"></p>
</div>


</body>
</html>

