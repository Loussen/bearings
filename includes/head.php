<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 1/16/17
 * Time: 6:18 PM
 */

// Get seo
if(!$cache->isCached('seo_'.$main_lang))
{
    $stmt_select = mysqli_prepare($db,"SELECT `description_`,`title_`,`keywords_` FROM `seo` WHERE `lang_id`=(?)");
    $stmt_select->bind_param('i', $main_lang);
    $stmt_select->execute();
    $stmt_select->bind_result($site_description,$site_title,$site_keywords);
    $stmt_select->fetch();
    $stmt_select->close();

    $description = $site_description;
    $title = $site_title;
    $image = SITE_PATH.'/images/logo.png';
    $keywords = $site_keywords;
    $og_url = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

    $cache->store('seo_'.$main_lang, [
        'description'   => $site_description,
        'title'         => $site_title,
        'image'         => SITE_PATH.'/images/logo.png',
        'keywords'      => $site_keywords
    ],500);
}
else
{
    $cache_seo_result = $cache->retrieve('seo_'.$main_lang);

    $description = $cache_seo_result['description'];
    $title = $cache_seo_result['title'];
    $image = $cache_seo_result['image'];
    $keywords = $cache_seo_result['keywords'];
    $og_url = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
}

// Get contacts
if(!$cache->isCached('contacts_'.$main_lang))
{
    $stmt_select = mysqli_prepare($db,"SELECT `email`,`facebook`,`twitter`,`youtube`,`address`,`google_map`,`skype`,`phone`,`footer`,`google` FROM `contacts` WHERE `lang_id`=(?)");
    $stmt_select->bind_param('i', $main_lang);
    $stmt_select->execute();
    $stmt_select->bind_result($email,$facebook,$twitter,$youtube,$address,$google_map,$skype,$phone,$footer,$google);
    $stmt_select->fetch();
    $stmt_select->close();

    $cache->store('contacts_'.$main_lang, [
        'email'         => $email,
        'facebook'      => $facebook,
        'twitter'       => $twitter,
        'youtube'       => $youtube,
        'address'       => $address,
        'google_map'    => $google_map,
        'skype'         => $skype,
        'phone'         => $phone,
        'google'         => $google,
        'footer'        => $footer
    ],1000);
}
else
{
    $cache_contacts_result = $cache->retrieve('contacts_'.$main_lang);

    $email = $cache_contacts_result['email'];
    $facebook = $cache_contacts_result['facebook'];
    $twitter = $cache_contacts_result['twitter'];
    $youtube = $cache_contacts_result['youtube'];
    $address = $cache_contacts_result['address'];
    $google_map = $cache_contacts_result['google_map'];
    $skype = $cache_contacts_result['skype'];
    $phone = $cache_contacts_result['phone'];
    $footer = $cache_contacts_result['footer'];
    $google = $cache_contacts_result['google'];
}

// partners
if(!$cache->isCached('partners_'.$main_lang))
{
    $stmt_select = mysqli_prepare($db,
        "SELECT
                        `title`,
                        `link`,
                        `image_name`
                        FROM `partners`
                        WHERE `lang_id`=(?) and `active`=(?)
                        order by `order_number` asc");

    $stmt_select->bind_param('ii', $main_lang,$active_status);
    $stmt_select->execute();
    $result_partners = $stmt_select->get_result();
    $stmt_select->close();

    $result_partners_arr = [];
    while($row=$result_partners->fetch_assoc())
    {
        $result_partners_arr[] = $row;
    }

    $cache->store('partners_'.$page.$main_lang,$result_partners_arr, 1000);
}
else
{
    $result_partners_arr = $cache->retrieve('partners_'.$page.$main_lang);
}

// Get menus
if(!$cache->isCached('menus_'.$main_lang))
{
    $stmt_select = mysqli_prepare($db,"SELECT `id`,`name`,`link`,`auto_id` FROM `menus` WHERE `lang_id`=(?) and `active`=(?) and `parent_auto_id`=(?) ORDER BY `order_number` ASC");
    $stmt_select->bind_param('iii', $main_lang,$active_status,$deactive_status);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $stmt_select->close();

    $result_menus_arr = [];
    while($row=$result->fetch_assoc())
    {
        $result_menus_arr[] = $row;
    }

    $cache->store('menus_'.$main_lang,$result_menus_arr, 300);
}
else
{
    $result_menus_arr = $cache->retrieve('menus_'.$main_lang);
}

// Do pages
if($do=="albums")
{
    // Albums
    if(!$cache->isCached('albums_'.$main_lang))
    {
        $stmt_select = mysqli_prepare($db,
            "SELECT
                `title`,
                `auto_id`,
                `image_name`,
                `created_at`
                FROM `alboms`
                WHERE `lang_id`=(?) and `active`=(?)
                ORDER BY `order_number`");
        $stmt_select->bind_param('ii', $main_lang,$active_status);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $stmt_select->close();

        $albums_arr = [];
        while($row=$result->fetch_assoc())
        {
            $albums_arr[] = $row;
        }

        $cache->store('albums_'.$main_lang,$albums_arr, 1000);
    }
    else
    {
        $albums_arr = $cache->retrieve('albums_'.$main_lang);
    }

    $title = 'Albums';

    // breadcrumbs
    $breadcrumbs = '<li>'.$lang16.'</li>';
    $breadcrumb_title = $lang16;
}
elseif($do=="album")
{
    if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['slug']) && !empty($_GET['slug']))
    {
        $album_id = intval($_GET['id']);
        $album_slug = mysqli_real_escape_string($db,$_GET['slug']);

        if(!$cache->isCached('album_inner_'.$album_id.$album_slug.$main_lang))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
                        `auto_id`,
                        `title`,
                        `image_name`,
                        `text`
                        FROM `alboms`
                        WHERE `lang_id`=(?) and `active`=(?) and `auto_id`=(?)
                        ");
            $stmt_select->bind_param('iii', $main_lang,$active_status,$album_id);
            $stmt_select->execute();
            $stmt_select->bind_result($current_album_id,$current_album_title,$current_album_image_name,$current_album_text);
            $stmt_select->fetch();
            $stmt_select->close();

            $cache->store('album_inner_'.$album_id.$album_slug.$main_lang,[
                'current_album_id'           => $current_album_id,
                'current_album_title'        => $current_album_title,
                'current_album_image_name'   => $current_album_image_name,
                'current_album_text'         => $current_album_text
            ],1000);
        }
        else
        {
            $cache_album_inner_result = $cache->retrieve('album_inner_'.$album_id.$album_slug.$main_lang);

            $current_album_id = $cache_album_inner_result['current_album_id'];
            $current_album_title = $cache_album_inner_result['current_album_title'];
            $current_album_image_name = $cache_album_inner_result['current_album_image_name'];
            $current_album_text = $cache_album_inner_result['current_album_text'];
        }

        if(!$cache->isCached('gallery_'.$album_id.$album_slug))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
                            `image_name`
                            FROM `gallery`
                            WHERE `albom_id`=(?)");
            $stmt_select->bind_param('i', $album_id);
            $stmt_select->execute();
            $result_albums_gallery = $stmt_select->get_result();
            $count_gallery = mysqli_num_rows($result_albums_gallery);
            $stmt_select->close();

            if($count_gallery>0)
            {
                $result_albums_gallery_arr = [];
                while($row=$result_albums_gallery->fetch_assoc())
                {
                    $result_albums_gallery_arr[] = $row;
                }

                $cache->store('gallery_'.$album_id.$album_slug,$result_albums_gallery_arr, 300);
            }
        }
        else
        {
            $result_albums_gallery_arr = $cache->retrieve('gallery_'.$album_id.$album_slug);
        }

//            if($album_id!=$current_album_id || $album_slug!=slugGenerator($current_album_title) || !$current_album_id)
//            {
//                header("Location: ".SITE_PATH."/404");
//                exit('Redirecting...');
//            }
    }
    else
    {
        header("Location: ".SITE_PATH."/404");
        exit('Redirecting...');
    }

    if(strlen($current_album_text)>3)
    {
        $description = mb_substr(strip_tags(html_entity_decode($current_album_text)),0,150,"UTF-8");
    }
    $title = $lang16." | ".$current_album_title;
    $image = SITE_PATH."/images/alboms/".$current_album_image_name;

    // breadcrumbs
    $breadcrumbs = '<li><a href="'.SITE_PATH.'/albums">'.$lang16.'</a></li>
                        <li>'.$lang1.'</li>';
    $breadcrumb_title = $lang16;
}
elseif($do=="page")
{
    if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['slug']) && !empty($_GET['slug']))
    {
        $page_id = intval($_GET['id']);
        $page_slug = mysqli_real_escape_string($db,$_GET['slug']);

        if(!$cache->isCached('page_inner_'.$page_id.$page_slug.$main_lang) || 1==1)
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
                    `auto_id`,
                    `name`,
                    `text`
                    FROM `menus`
                    WHERE `lang_id`=(?) and `active`=(?) and `auto_id`=(?)
                    ");
            $stmt_select->bind_param('iii', $main_lang,$active_status,$page_id);
            $stmt_select->execute();
            $stmt_select->bind_result($current_page_id,$current_page_title,$current_page_text);
            $stmt_select->fetch();
            $stmt_select->close();

            $cache->store('page_inner_'.$page_id.$page_slug.$main_lang,[
                'current_page_id'           => $current_page_id,
                'current_page_title'        => $current_page_title,
                'current_page_text'         => $current_page_text
            ],1000);
        }
        else
        {
            $cache_page_inner_result = $cache->retrieve('page_inner_'.$page_id.$page_slug.$main_lang);

            $current_page_id = $cache_page_inner_result['current_page_id'];
            $current_page_title = $cache_page_inner_result['current_page_title'];
            $current_page_text = $cache_page_inner_result['current_page_text'];
        }

//            if($page_id!=$current_page_id || $page_slug!=slugGenerator($current_page_title) || !$current_page_id)
//            {
//                header("Location: ".SITE_PATH."/404");
//                exit('Redirecting...');
//            }
    }
    else
    {
        header("Location: ".SITE_PATH."/404");
        exit('Redirecting...');
    }

    $description = mb_substr(strip_tags(html_entity_decode($current_page_text)),0,150,"UTF-8");
    $title = $current_page_title;

    // breadcrumbs
    $breadcrumbs = '<li>'.$current_page_title.'</li>';
    $breadcrumb_title = $current_page_title;
}
elseif($do=="blog")
{
    // Paginator
    $limit = 6;

    $stmt_select = mysqli_prepare($db,
        "SELECT
                    `auto_id`
                    FROM `news`
                    WHERE `lang_id`=(?) and `active`=(?)
                    ");
    $stmt_select->bind_param('ii', $main_lang,$active_status);
    $stmt_select->execute();
    $stmt_select->store_result();

    $count_rows = $stmt_select->num_rows;
    $max_page=ceil($count_rows/$limit);
    $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
    if($page<1) $page = 1;
    $start=$page*$limit-$limit;
    $stmt_select->close();

    if(!$cache->isCached('result_news_'.$page.$main_lang))
    {
        // Get news by category
        $stmt_select = mysqli_prepare($db,
            "SELECT
                    `auto_id`,
                    `title`,
                    `short_text`,
                    `text`,
                    `image_name`,
                    `created_at`,
                    `view`
                    FROM `news`
                    WHERE `lang_id`=(?) and `active`=(?)
                    order by `created_at` desc limit $start,$limit");

        $stmt_select->bind_param('ii', $main_lang,$active_status);
        $stmt_select->execute();
        $result_news = $stmt_select->get_result();
        $stmt_select->close();

        $result_news_arr = [];
        while($row=$result_news->fetch_assoc())
        {
            $result_news_arr[] = $row;
        }

        $cache->store('result_news_'.$page.$main_lang,$result_news_arr, 300);
    }
    else
    {
        $result_news_arr = $cache->retrieve('result_news_'.$page.$main_lang);
    }

    $title = "News";

    // breadcrumbs
    $breadcrumbs = '<li>'.$lang2.'</li>';
    $breadcrumb_title = $lang2;
}
elseif($do=="news")
{
    if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['slug']) && !empty($_GET['slug']))
    {
        $news_id = intval($_GET['id']);
        $news_slug = mysqli_real_escape_string($db,$_GET['slug']);

        // Get news info
        if(!$cache->isCached('news_inner_'.$news_id.$news_slug.$main_lang))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
                        `news`.`auto_id` as `news_id`,
                        `news`.`title` as `news_title`,
                        `news`.`image_name` as `news_image_name`,
                        `news`.`short_text` as `news_short_text`,
                        `news`.`text` as `news_text`,
                        `news`.`created_at` as `news_created_at`,
                        `news`.`view` as `news_view`
                        FROM `news`
                        WHERE `news`.`lang_id`=(?) and `news`.`active`=(?) and `news`.`auto_id`=(?) and `news`.`title`!=''
                        ");
            $stmt_select->bind_param('iii', $main_lang,$active_status,$news_id);
            $stmt_select->execute();
            $stmt_select->bind_result($current_news_id,$current_news_title,$current_news_image_name,$current_news_short_text,$current_news_text,$current_news_created_at,$current_news_view);
            $stmt_select->fetch();
            $stmt_select->close();

            $cache->store('news_inner_'.$news_id.$news_slug.$main_lang,[
                'current_news_id'           => $current_news_id,
                'current_news_title'        => $current_news_title,
                'current_news_image_name'   => $current_news_image_name,
                'current_news_text'         => $current_news_text,
                'current_news_short_text'   => $current_news_short_text,
                'current_news_created_at'   => $current_news_created_at,
                'current_news_view'         => $current_news_view
            ],100);
        }
        else
        {
            $cache_news_inner_result = $cache->retrieve('news_inner_'.$news_id.$news_slug.$main_lang);

            $current_news_id = $cache_news_inner_result['current_news_id'];
            $current_news_title = $cache_news_inner_result['current_news_title'];
            $current_news_image_name = $cache_news_inner_result['current_news_image_name'];
            $current_news_text = $cache_news_inner_result['current_news_text'];
            $current_news_short_text = $cache_news_inner_result['current_news_short_text'];
            $current_news_created_at = $cache_news_inner_result['current_news_created_at'];
            $current_news_view = $cache_news_inner_result['current_news_view'];

            mysqli_query($db, "UPDATE `news` SET `view`=`view`+1 WHERE `auto_id`='$current_news_id'");
        }

//            if($news_id!=$current_news_id || $news_slug!=slugGenerator($current_news_title) || !$current_news_id)
//            {
//                header("Location: ".SITE_PATH."/404");
//                exit('Redirecting...');
//            }
    }
    else
    {
        header("Location: ".SITE_PATH."/404");
        exit('Redirecting...');
    }

    $description = mb_substr($current_news_short_text,0,150,"UTF-8");;
    $title = $lang2." | ".$current_news_title;
    if(strlen($current_news_image_name)>3)
    {
        $image = SITE_PATH."/news/".$current_news_image_name;
    }

    // breadcrumbs
    $breadcrumbs = '<li><a href="'.SITE_PATH.'/blog">'.$lang2.'</a></li>
                        <li>'.$current_news_title.'</li>';
    $breadcrumb_title = $current_news_title;
}
else
{
    // Sliders
    if(!$cache->isCached('sliders_'.$main_lang))
    {
        $stmt_select = mysqli_prepare($db,
            "SELECT
                `image_name`
                FROM `sliders`
                WHERE `lang_id`=(?) and `active`=(?)
                ORDER BY `order_number`");
        $stmt_select->bind_param('ii', $main_lang,$active_status);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $stmt_select->close();

        $sliders_arr = [];
        while($row=$result->fetch_assoc())
        {
            $sliders_arr[] = $row;
        }

        $cache->store('sliders_'.$main_lang,$sliders_arr, 1000);
    }
    else
    {
        $sliders_arr = $cache->retrieve('sliders_'.$main_lang);
    }

    // home news
    if(!$cache->isCached('result_home_news_'.$main_lang))
    {
        $stmt_select = mysqli_prepare($db,
            "SELECT
                    `auto_id`,
                    `title`,
                    `short_text`,
                    `image_name`,
                    `view`,
                    `created_at`
                    FROM `news`
                    WHERE `lang_id`=(?) and `active`=(?)
                    order by `created_at` desc limit 6");

        $stmt_select->bind_param('ii', $main_lang,$active_status);
        $stmt_select->execute();
        $result_news = $stmt_select->get_result();
        $stmt_select->close();

        $result_home_news_arr = [];
        while($row=$result_news->fetch_assoc())
        {
            $result_home_news_arr[] = $row;
        }

        $cache->store('result_home_news_'.$page.$main_lang,$result_home_news_arr, 1000);
    }
    else
    {
        $result_home_news_arr = $cache->retrieve('result_home_news_'.$page.$main_lang);
    }
}
?>

<!-- meta tag -->
<meta charset="utf-8">

<!-- responsive tag -->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="description" content="<?=$description?>"/>
<meta property="keywords" content="<?=$keywords?>"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="<?=$image?>"/>
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />
<meta property="og:title" content="<?=$title?>"/>
<meta property="og:url" content="<?=$og_url?>"/>
<meta property="og:description" content="<?=$description?>"/>

<!-- favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_PATH?>/assets/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_PATH?>/assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_PATH?>/assets/favicon/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?=SITE_PATH?>/assets/favicon/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="512x512" href="<?=SITE_PATH?>/assets/favicon/android-chrome-512x512.png">
<link rel="manifest" href="<?=SITE_PATH?>/assets/favicon/site.webmanifest">

<!-- bootstrap v3.3.7 css -->
<link rel="stylesheet" type="text/css" href="<?=SITE_PATH?>/assets/css/style.css">

<!-- responsive css -->
<link rel="stylesheet" type="text/css" href="<?=SITE_PATH?>/assets/css/responsive.css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="<?=SITE_PATH?>/assets/vendor/html5shiv.js"></script>
<![endif]-->

<title>Bearing | <?=$title?></title>

<script>
    var base_url = '<?=SITE_PATH?>';
</script>

