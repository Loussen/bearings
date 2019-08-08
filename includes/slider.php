<div id="rs-slider" class="rs-slider rs-slider-one">
    <div class="bend niceties">
        <div id="nivoSlider" class="slides">
            <?php
                $i=1;
                foreach ($sliders_arr as $slider)
                {
                    ?>
                    <img src="<?=SITE_PATH?>/images/slider/<?=$slider['image_name']?>" alt="slider" title="#slide-<?=$i?>"/>
                    <?php
                    $i++;
                }
            ?>
        </div>
        <!-- Slide 1 -->
<!--        <div id="slide-1" class="slider-direction">-->
<!--            <div class="display-table">-->
<!--                <div class="display-table-cell">-->
<!--                    <div class="container">-->
<!--                        <div class="slider-des">-->
<!--                            <h3 class="sl-sub-title">Corporate Solutions</h3>-->
<!--                            <h1 class="sl-title">Best Business<br>HTML5 Template</h1>-->
<!--                            <div class="sl-desc margin-0">-->
<!--                                Best Multipurpose Creative Business Template 2018-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="slider-bottom">-->
<!--                            <ul>-->
<!--                                <li><a href="#" class="readon">Buy Now</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <!-- Slide 2 -->
<!--        <div id="slide-2" class="slider-direction">-->
<!--            <div class="display-table">-->
<!--                <div class="display-table-cell">-->
<!--                    <div class="container">-->
<!--                        <div class="slider-des">-->
<!--                            <h3 class="sl-sub-title">Business Solutions</h3>-->
<!--                            <h1 class="sl-title">We Create<br>Nice Template</h1>-->
<!--                            <div class="sl-desc margin-0">-->
<!--                                Best Multipurpose Creative Business Template 2018-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="slider-bottom">-->
<!--                            <ul>-->
<!--                                <li><a href="#" class="readon">Buy Now</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>