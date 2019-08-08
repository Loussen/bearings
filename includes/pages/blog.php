<div class="main-content">
    <?php
        require_once ("includes/breadcrumb.php");
    ?>

    <section id="rs-blog" class="rs-blog sec-spacer">
        <div class="container">
            <div class="sec-title">
                <h3><?=$lang2?></h3>
            </div>
            <div class="row">
                <?php
                    foreach ($result_news_arr as $item)
                    {
                        ?>
                        <div class="col-12 col-md-4 mb-md-5 md-4">
                            <div class="blog-item">
                                <div class="blog-img">
<!--                                    <img src="--><?//=SITE_PATH?><!--/images/news/--><?//=$item['image_name']?><!--" alt="--><?//=$item['title']?><!--">-->
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
            </div>

            <?php
                if($count_rows > $limit)
                {
                    $show = 5;

                    ?>
                    <div class="row">
                        <div class="rs-shop col-12">
                            <div class="bullet">
                                <ul>
                                    <?php
                                        if($page>1)
                                        {
                                            ?>
                                            <li><a href="<?=SITE_PATH?>/blog/1"><i class="fa fa-long-arrow-left"></i></a></li>
                                            <li><a href="<?=SITE_PATH?>/blog/<?=$page-1?>"><i class="fa fa-arrow-left"></i></a></li>
                                            <?php
                                        }

                                        for ($i = $page - $show; $i <= $page + $show; $i++)
                                        {
                                            if ($i > 0 && $i <= $max_page)
                                            {
                                                if ($i == $page)
                                                {
                                                    ?>
                                                    <li class="active"><a href="javascript::void(0);"><?=$i?></a></li>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <li><a href="<?=SITE_PATH?>/blog/<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                        }

                                        if ($page < $max_page)
                                        {
                                            ?>
                                            <li><a href="<?=SITE_PATH?>/blog/<?=($page + 1)?>"><i class="fa fa-arrow-right"></i></a></li>
                                            <li><a href="<?=SITE_PATH?>/blog/<?=$max_page?>"><i class="fa fa-long-arrow-right"></i></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </section>

</div>

<?php
    require_once ("includes/partner.php");
?>