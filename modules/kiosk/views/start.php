<?php

?>

<section id="main">

    <div id="burger-header">
    </div>
    <div id="innholdsbox1">


        <script src="resources/img/kiosk/js/functions.js" type="text/javascript"></script>

        <ul class="top-label">
            <!--  <li class="label-txt"><a id="tab_1" href="javascript:tabSwitch_2(1, 3, 'tab_', 'innhold_');"> Burger </a></li>
               <!--  <li class="label-txt"><a id="tab_1" href="javascript:tabSwitch_2(1, 3, 'tab_', 'innhold_');"> Burger </a></li>
               <!--|<li class="label-txt"><a id="tab_2" href="javascript:tabSwitch_2(2, 3, 'tab_', 'innhold_');"> Pizza </a></li>
               |<li class="label-txt"><a id="tab_3" href="javascript:tabSwitch_2(3, 3, 'tab_', 'innhold_');"> Drikke </a></li>
            --></ul>



        <div class="content drag-desired">

            <div id="innhold_1" class="">
                <?php foreach ($data['products']['burger'] as $product) : ?>
                <div class="product"><img src="resources/img/kiosk/img/products/<?php echo $product->getImage(); ?>" alt="<?php echo $product->getName(); ?>" width="64" height="64" class="pngfix" /></div>
                <?php endforeach; ?>

            </div>

            <div id="innhold_2" class="innhold">

                <?php
                /*
                                    $result = mysql_query("SELECT * FROM internet_shop WHERE type ='pizza'");
                                    while($row=mysql_fetch_assoc($result))
                                    {
                                        echo '<div class="product"><img src="kiosk/img/products/'.$row['img'].'" alt="'.htmlspecialchars($row['name']).'" width="64" height="64" class="pngfix" /></div>';
                                    }
                */
                ?>
            </div>

            <div id="innhold_3" class="innhold">
                <?php foreach ($data['products']['drikke'] as $product) : ?>
                <div class="product"><img src="resources/img/kiosk/img/products/<?php echo $product->getImage(); ?>" alt="<?php echo $product->getName(); ?>" width="64" height="64" class="pngfix" /></div>
                <?php endforeach; ?>
            </div>

            <div class="clear"></div>
        </div>


    </div>

    <div id="innholdsbox2">


        <div class="container">


            <span class="label-txt">Bestillinger</span>




            <div class="content drop-here">
                <div id="cart-icon">
                    <img src="resources/img/kiosk/img/Shoppingcart_128x128.png" alt="shopping cart" class="pngfix" width="64" height="64" />
                    <img src="resources/img/kiosk/img/ajax_load_2.gif" alt="loading.." id="ajax-loader" width="16" height="16" />
                </div>

                <form name="checkoutForm" method="post" action="?m=kiosk&act=finished">
                    <input type="hidden" name="hiddenBrukerID" value="<?php echo $_SESSION['user_id']; ?>" />
                    <div id="item-list">
                    </div>
                    <input type="radio" name="payType" value="kontant" /> Kontant
                    <input type="radio" name="payType" value="kort" /> Kort
                </form>
                <div class="clear"></div>

                <div id="total"></div>

                <div class="clear"></div>
                <a href="#dialog2" name="modal" class="button" onclick="sjekkBurger();" >Fortsett</a>

            </div>


        </div>

    </div>

    <div id="boxes">


        <div id='dialog2' class='window' >

            <br />

            <center><b id="dialogBeskjed">Er du sikker på at du vil fortsette?</b> </center> <br />

            <a href='' onclick='' name='modal' class='close button' >Avbryt</a>
            <a href='' id="rForts" onclick='document.checkoutForm.submit(); return false;'  class='button' style='visibility: hidden;'>Fortsett</a>

        </div>

        <!--	<div id='dialog3' class='window' >

           <b> Du MÅ kjøpe burger for å bruke dette systemet! </b>

           </div>

        End of Sticky Note
       <a href='' onclick='' name='modal' class='close button' >Avbryt</a>
       <a href='' onclick='document.forms.checkoutForm.submit(); return false;' name='modal' class='button' >Fortsett</a>

         Du kan ikke fortsette uten å kjøpe Burger!  <br/><br />
        -->



        <!-- Mask to cover the whole screen -->
        <div id="mask"></div>
    </div>



</section>
