<?php
    foreach ($result_home_news_arr as $item)
    {
        ?>
        <div class="col-12 col-md-4 mb-md-5 md-4">
            <div class="blog-item">
                <div class="blog-img">
<!--                    <img src="--><?//=SITE_PATH?><!--/images/news/--><?//=$item['image_name']?><!--" alt="--><?//=$item['title']?><!--">-->
                    <div class="blog-img-content">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <a class="blog-link" href="<?=SITE_PATH."/news/".slugGenerator($item['title'])."-".$item['auto_id']?>" title="<?=$item['title']?>">
                                    <i class="fa fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-wrapper">
                    <div class="blog-meta">
                        <ul>
                            <?php
                                $month = date("m",$item['created_at']);
                                $year = date("Y",$item['created_at']);
                                $day = date("d",$item['created_at'])
                            ?>
                            <li><i class="fa fa-calendar"></i><span><?=getMonth($month,$main_lang)." ".$day.", ".$year?></span></li>
                            <li><i class="fa fa-eye"></i><span><?=$item['view']?> <?=$lang3?></span></li>
                        </ul>
                    </div>
                    <div class="blog-desc">
                        <a href="<?=SITE_PATH."/news/".slugGenerator($item['title'])."-".$item['auto_id']?>" title="<?=$item['title']?>"><?=more_string($item['title'],50)?></a>
                        <p><?=more_string($item['short_text'],100)?></p>
                    </div>
                    <a href="<?=SITE_PATH."/news/".slugGenerator($item['title'])."-".$item['auto_id']?>" class="readon"><?=$lang4?></a>
                </div>
            </div>
        </div>
        <?php
    }
?>