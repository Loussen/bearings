<section class="main-content">
    <!-- Breadcrumbs Start -->
    <?php
        require_once ("includes/breadcrumb.php");
    ?>
    <!-- Breadcrumbs End -->

    <!-- Project Section Start -->
    <div id="rs-portfolio" class="rs-portfolio sec-spacer">
        <div class="container">
            <div class="gridFilter text-center">
                <!--<button class="active" data-filter="*">All Projects</button>-->
            </div><!-- .gridFilter end-->
            <div class="row grid">
                <?php
                    foreach ($albums_arr as $item)
                    {
                        ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-30 grid-item">
                            <div class="gallery-item popup-inner">
                                <div class="gallery-content">
                                    <img src="<?=SITE_PATH?>/images/alboms/<?=$item['image_name']?>" alt="<?=$item['title']?>" />
                                    <div class="popup-text">
                                        <div class="contents-here">
                                            <a class="icon-part" href="<?=SITE_PATH."/album/".slugGenerator($item['title'])."-".$item['auto_id']?>">
                                                <i class="fa fa-link" aria-hidden="true"></i>
                                            </a>
                                            <h4 class="title"><a href="<?=SITE_PATH."/album/".slugGenerator($item['title'])."-".$item['auto_id']?>"><?=$item['title']?></a></h4>
                                            <ul>
                                                <li>
                                                    <span class="desination"><?=date("d.m.Y",$item['created_at'])?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Project Section End -->
</section>

<?php
    require_once ("includes/partner.php");
?>