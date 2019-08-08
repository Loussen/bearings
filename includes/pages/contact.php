<!-- Inner Page Banner ______________________ -->
<div class="inner-banner">
    <div class="opacity">
        <div class="container">
            <div class="page-title clear-fix">
                <h2 class="float-left">CONTACT US</h2>
                <ul class="float-right">
                    <li><a href="index.html" class="tran3s">Home</a></li>
                    <li>/</li>
                    <li><a href="#" class="tran3s">Page</a></li>
                    <li>/</li>
                    <li class="active">CONTACT US</li>
                </ul>
            </div> <!-- .page-title -->
        </div> <!-- /.container -->
    </div> <!-- /.opacity -->
</div> <!-- /.inner-banner -->


<!-- Contact us Details ______________________ -->
<div class="contact-us-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 contact-us-form">
                <form action="inc/sendemail.php" class="form-validation" autocomplete="off">
                    <h6>SEND US A MESSAGE</h6>
                    <div class="form-wrapper">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="text" placeholder="Your Name" name="name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="email" placeholder="Your Email" name="email">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <textarea placeholder="Your Comment" name="message"></textarea>
                            </div>
                        </div>
                        <button class="tran3s p-color-bg"><i class="fa fa-pencil" aria-hidden="true"></i> SUBMIT MESSAGE</button>
                    </div> <!-- /.form-wrapper -->
                </form>

                <!-- Contact alert -->
                <div class="alert_wrapper" id="alert_success">
                    <div id="success">
                        <button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <div class="wrapper">
                            <p>Your message was sent successfully.</p>
                        </div>
                    </div>
                </div> <!-- End of .alert_wrapper -->
                <div class="alert_wrapper" id="alert_error">
                    <div id="error">
                        <button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <div class="wrapper">
                            <p>Something went wrong, try refreshing and submitting the form again!</p>
                        </div>
                    </div>
                </div> <!-- End of .alert_wrapper -->
            </div> <!-- /.contact-us-form -->

            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 contact-address">
                <div class="address-wrapper">
                    <h6>CONTACT DETAILS</h6>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consectetur, adipisci velit,</p>
                    <ul>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> Board Bazar Road, 1780BR<br>Gazipur, Dhaka ,NY</li>
                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i> Help@eFinance.com <br>Help@eFinance.com</li>
                        <li><i class="fa fa-phone-square" aria-hidden="true"></i> +088 1712570051 <br>+8801912704287</li>
                    </ul>
                </div> <!-- /.address-wrapper -->
            </div> <!-- /.contact-address -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.contact-us-details -->


<!-- Google Map _______________________ -->
<div id="google-map-area" class="wow fadeInUp">
    <div class="google-map" id="contact-google-map" data-map-lat="40.925372" data-map-lng="-74.276544" data-icon-path="images/logo/map.png" data-map-title="Find Map" data-map-zoom="12"></div>
</div>