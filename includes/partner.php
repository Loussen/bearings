<div id="rs-defult-partner" class="rs-defult-partner sec-color pt-100 pb-100">
    <div class="container">
        <div class="rs-carousel owl-carousel" data-loop="true" data-items="5" data-margin="30" data-autoplay="true" data-autoplay-timeout="8000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="2" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="3" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="5" data-md-device-nav="true" data-md-device-dots="false">
            <?php
                foreach ($result_partners_arr as $item)
                {
                    ?>
                    <div class="partner-item">
                        <a href="<?=$item['link']?>"><img src="<?=SITE_PATH?>/images/partners/<?=$item['image_name']?>" alt="<?=$item['title']?>"></a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>