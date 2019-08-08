<div class="main-content">
    <?php
        require_once ("includes/breadcrumb.php");
    ?>

    <!-- Blog Detail Start -->
    <div class="rs-blog-details sec-spacer">
        <div class="container">
            <div class="full-width-blog">

                <div class="h-info">
                    <ul class="h-meta">
                        <li>
                            <span class="p-date">
                                <i class="fa fa-calendar"></i><?=getMonth(date("m",$current_news_created_at),$main_lang)." ".date("d",$current_news_created_at).", ".date("Y",$current_news_created_at)?>
                            </span>
                        </li>

                        <li class="category-name">
                            <span class="p-cname">
                                <i class="fa fa-eye"></i><?=$current_news_view?>
                            </span>
                        </li>

                    </ul>
                </div>

                <div class="h-desc">
                    <div class="replaceHref">
                        <?=html_entity_decode($current_news_text)?>
                    </div>
                </div>

                <?php
                    require_once ("includes/sharer.php");
                ?>
            </div>
        </div>
    </div>
</div>

<?php
    require_once ("includes/partner.php");
?>