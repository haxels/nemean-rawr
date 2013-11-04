<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nemean - Presentasjon</title>
    <link href="resources/site/html/new/css/reveal.css" rel="stylesheet" type="text/css" />
    <link href="resources/site/html/new/css/presentation.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="resources/site/html/new/js/reveal.js"></script>

</head>
<body>

    <div class="reveal centered">
        <div class="header"><img src="resources/site/html/admin/img/nemean2013.png" width="15%"/></div>

<hr>
        <div class="slides" id="presentationHolder">

        <?php

        $slides = $data['presentation'];
        $num = count($slides);
        for ($i = 0; $i < $num; $i++){
            $slide = $slides[$i];
        ?>
            <section class="nSlide">

                <div class="title">
                    <?php echo $slide->getTitle();?>
                </div>

                <div class="content">
                    <?php $slide->printContent();?>
                </div>

            </section>

        <?php
            }
            ?>
            <section class="nSlide" data-state="updateSlides">



            </section>
        </div>


    </div>
    <div id="sponsorer">
        <hr>
        <a href="http://www.sparebankenhemne.no"  target="_blank"><img border="none"  src="resources/site/img/sponsorer/sbh.gif" width="200"/></a>
        <a href="http://www.hemnenett.no"         target="_blank"><img border="none"src="resources/site/img/sponsorer/hemnenett.gif" width="200" /></a>
        
        <!-- <div id="sponsor"><a href="http://www.lundbakeri.no/"       target="_blank"><img border="none" style="padding-left:7px;" src="resources/site/img/sponsorer/lund.png" width="160" /></a></div>
        -->
    </div>
</body>
</html>