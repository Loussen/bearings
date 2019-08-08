<section class="main-content">
    <?php
        require_once ("includes/breadcrumb.php");
    ?>

    <!-- Project style Start -->
    <div id="rs-project-style" class="rs-project-style pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-md-30">
                    <div class="project-desc">
                        <h3><?=$current_page_title?></h3>
                        <div class="replaceHref">
                            <?=html_entity_decode($current_page_text)?>
                        </span>
                    </div>

                    <?php
                        require_once ("includes/sharer.php");
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Project Gallery End -->
</section>

<?php
    require_once ("includes/partner.php");
?>