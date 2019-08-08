<section class="main-content">
    <!-- Breadcrumbs Start -->
    <?php
        require_once ("includes/breadcrumb.php");
    ?>
    <!-- Breadcrumbs End -->

    <!-- Project style Start -->
    <div id="rs-project-style" class="rs-project-style pt-100 pb-100">
        <div class="container">

            <div class="p-style-wrap">
                <h3 class="p-style-title"><?=$current_album_title?></h3>
                <div class="row">
                    <?php
                        foreach ($result_albums_gallery_arr as $item)
                        {
                            ?>
                            <div class="col-md-4 col-sm-12 mb-sm-30 mb-4">
                                <div class="item-grid">
                                    <div class="image-icon">
                                        <img src="<?=SITE_PATH?>/images/gallery/<?=$item['image_name']?>" alt="<?=$current_album_title?>">
                                        <a class="image-popup" href="<?=SITE_PATH?>/images/gallery/<?=$item['image_name']?>"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="col-md-12">
                    <?=html_entity_decode($current_album_text)?>
                </div>
            </div>
        </div>
    </div>
    <!-- Project Gallery End -->
</section>

<?php
    require_once ("includes/partner.php");
?>