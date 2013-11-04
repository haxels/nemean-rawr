

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
