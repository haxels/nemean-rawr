<?php

?>
<section id="main">
    <div id="burger-header"></div>

    <div id="innholdsbox1">

        <?php

        if (isset($data['error']))
        {
            echo $data['error'];
            exit();
        }
        ?>

        <h1>Du bestilte:</h1>
        <?php foreach ($data['products'] as $product) : ?>
        <li><?php echo $product->getName(); ?></li>
        <?php endforeach; ?>
        <h1>Totalt: <?php echo $data['total']; ?> Kr</h1>
        <br /><h2> Din ordreID er: <?php echo $data['order_id']; ?>! Husk denne!
        <!-- <br /><h3>Din bestilling er klar om ca 10 minutter</h3> -->

    </div>
</section>