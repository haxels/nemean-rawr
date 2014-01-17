<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nemean - Presentasjon</title>
    <link href="site/css/reveal.css" rel="stylesheet" type="text/css" />
    <link href="site/css/presentation.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="site/js/reveal.js"></script>

</head>
<body>

    <div class="reveal centered">
        <div class="header"><img src="site/img/logo.jpg" width="12%"/></div>

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
        
    </div>
</body>
</html>