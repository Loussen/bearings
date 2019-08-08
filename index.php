<?php
    include "bpmanager/pages/includes/config.php";
    $do=safe($_GET["do"]);
    if(!is_file("includes/pages/".$do.".php")) $do='index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.php"; ?>
</head>
<body>

<input type="hidden" name="csrf_" value="<?=set_csrf_()?>" />

<div class="main-page-wrapper">
    <?php include "includes/header.php"; ?>

    <?php include "includes/pages/".$do.".php"; ?>

    <?php include "includes/footer.php"; ?>
</div>

<!-- Js File_________________________________ -->

<!-- j Query -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/jquery-2.1.4.js"></script>

<!-- Bootstrap JS -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/bootstrap/bootstrap.min.js"></script>

<!-- Vendor js _________ -->
<!-- revolution -->
<script src="<?=SITE_PATH?>/assets/vendor/revolution/jquery.themepunch.tools.min.js"></script>
<script src="<?=SITE_PATH?>/assets/vendor/revolution/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/revolution/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/revolution/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/revolution/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/revolution/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/revolution/revolution.extension.actions.min.js"></script>

<!-- Google map js -->
<script src="http://maps.google.com/maps/api/js"></script> <!-- Gmap Helper -->
<script src="<?=SITE_PATH?>/assets/vendor/gmap.js"></script>
<!-- WOW js -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/WOW-master/dist/wow.min.js"></script>
<!-- owl.carousel -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/owl-carousel/owl.carousel.min.js"></script>
<!-- js count to -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/jquery.appear.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/jquery.countTo.js"></script>

<!-- Validation -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/contact-form/validate.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/contact-form/jquery.form.js"></script>

<!-- Progress Bar js -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/vendor/skills-master/jquery.skills.js"></script>

<!-- Theme js -->
<script type="text/javascript" src="<?=SITE_PATH?>/assets/js/theme.js"></script>

<?php
    if($do=="contact")
    {
        ?>
        <script type="text/javascript" src="<?=SITE_PATH?>/assets/js/map-script.js"></script>
        <?php
    }
?>

<script>
    $(document).on('submit','form.contact-form',function(e){
        e.preventDefault();

        $('#loading-image').show();
        $('#loading').css('opacity','0.3');
        $('.has-error').removeClass('has-error');

        var formData = new FormData(this);

        $.ajax({
            url: base_url+'/contact.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data.code==0)
                {
                    $('html, body').animate({
                        scrollTop: $('[name="'+data.err_param+'"]').offset().top-80
                    }, 500);
                    $('[name="'+data.err_param+'"]').addClass('has-error');
                }
                else
                {
                    $('html, body').animate({
                        scrollTop: $('form.contact-form').offset().top-80
                    }, 500);

                    $("form.contact-form").css("display","none");
                    $('#loading-image').hide();
                    $('div.success_contact').show();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loading-image').hide();
                $('#contact_loading').css('opacity','1');

            }
        });

    });
</script>

</body>
</html>