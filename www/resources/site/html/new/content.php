<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 04.07.12
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */
?>

        <div id="content">

            <div class="spacer"></div>

            <aside id="sidebar">

                <?php
                $settings = $data['settings'];

                if(count($submenu) > 0)
                {
                    echo $menu[$_GET['pID']]->getLabel();
                }

                else
                {
                	echo "<br>Info i farta";
                    echo "<div id='siteinfo'><br><b>Når?</b><br>";
                    echo "9.-13. oktober 2013<br><br><br>";
                    echo "<b>Hvor?</b><br>Kyrksæterøra, <br>Sør-Trøndelag<br><br>";
                    echo "<b>Pris?</b><br>";
                    echo /*"<br><p>PGA: &nbsp &nbsp <b>500,00</b></p><p>Kombi: &nbsp<b>650,00</b></p>*/"<p>Delta:&nbsp;  <b>&nbsp;".$settings['deltaker_pris']->getValue()."</b></p> <p>Besøk:&nbsp <b>".$settings['besokende_pris']->getValue()."</b></p>";
                    //echo "<br><br><a style='cursor: pointer' id='registerBtn'>Registrer deg her</a>";
                }

                ?>

                <br><br>
                <?php foreach ($submenu as $item) : ?>
                <li><a href="<?php echo $item->getLink(); ?>&pID=<?php echo $_GET['pID']; ?>"><?php echo $item->getLabel(); ?></a></li>
                <?php endforeach; ?><br>

                <?php ($data['left'] != null) ? $data['left']->leftContent() : ''; ?>

                <br /><br /><br />

            </aside>



            <section>
                <?php
                if ($data['content'] != null)
                {
                    $data['content']->display();
                }
                ?>
                <br /><br /><br /><br />
            </section>



        </div>
            <div id="sponsorer">

                <div id="sponsor"><a href="http://www.sparebankenhemne.no"  target="_blank"><img border="none"  style="padding-left:7px;"src="resources/site/img/sponsorer/sbh.gif" width="160"/></a></div>
                <div id="sponsor"><a href="http://www.hemnenett.no"         target="_blank"><img style="padding-left:7px;" border="none" src="resources/site/img/sponsorer/hemnenett.gif" width="160" /></a></div>
                <div id="sponsor"><a href="http://www.mot.no"               target="_blank"><img border="none" style="padding-left:7px;" src="resources/site/img/sponsorer/mot.png" width="160" /></a></div>
                <div id="sponsor"><a href="http://steelseries.com"            target="_blank"><img border="none" style="margin-bottom: 7px;padding-left:7px;" src="resources/site//img/sponsorer/steelseries.png" width="160" /></a></div>
                <div id="sponsor"><a href="http://www.tronderenerginett.no"            target="_blank"><img border="none" style="margin-bottom: 7px;padding-left:7px;" src="resources/site//img/sponsorer/tronderenergi.jpg" width="160" /></a></div>
               <!-- <div id="sponsor"><a href="http://www.lundbakeri.no/"       target="_blank"><img border="none" style="padding-left:7px;" src="resources/site/img/sponsorer/lund.png" width="160" /></a></div>
                -->

            </div>