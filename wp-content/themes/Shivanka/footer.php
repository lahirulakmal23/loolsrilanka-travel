    <!-- Footer -->
    <footer class="footer p-top-90 p-bottom-90" data-aos="fade">

        <!-- Footer top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-3 col-md-6">
                        <!-- Brand -->
                        <div class="footer-widget footer_logo">
                            <a href="<?php echo home_url(); ?>" class="brand-img ">
                                <img class="me-4" 
                                    src="<?php echo get_field('footer_logo', 'option'); ?>" 
                                    srcset="<?php echo get_field('footer_logo', 'option'); ?>" 
                                    alt="<?php bloginfo('name'); ?>">
                            </a>
                           
                        </div>
                        <!-- /Brand -->
                    </div>
                    <div class="col-12 col-xl-3 col-md-6">
                        <!-- Contact Info -->
                        <div class="footer-widget">
                            <h2 class="h4 pb-3">Contact Info</h2>
                            <div class="contact-info">
                                <p><span><?php echo esc_html(get_field('address','option')); ?></span></p>
                            <p>
  <a href="tel:<?php echo esc_attr(get_field('phone_number', 'option')); ?>">
    <?php echo esc_html(get_field('phone_number', 'option')); ?>
  </a>
</p>
                                <p><a href="mailto:<?php echo esc_attr(get_field('email_address','option')); ?>">
                                    <?php echo esc_html(get_field('email_address','option')); ?></a></p>
                            </div>
                        </div>
                        <!-- /Contact Info -->
                    </div>
                    <div class="col-12 col-xl-3 col-md-6">
                        <!-- Quick Links -->
                        <div class="footer-widget">
                            <h2 class="h4 pb-3">LSL Adventure Travels</h2>
                            <?php 
                            // Dynamic menu from WordPress
                            wp_nav_menu( array(
                                'theme_location' => 'footer-menu',
                                'menu_class'     => 'footer-link',
                                'container'      => false,
                            ) ); 
                            ?>
                        </div>
                        <!-- /Quick Links -->
                    </div>
                    <div class="col-12 col-xl-3 col-md-6">
                        <div class="footer-widget">
                            <h2 class="h4 pb-3">Find us on</h2>
                            <!-- Mobile App -->
                            <div class="mb-5 pt-3">
                                <div class="social-icon">
                                    <a href="https://www.instagram.com/lsladventuretours/" target="_blank">
                                        <i class="fa fa-instagram"></i>
                                    </a> <span class="vr bg-white d-none d-md-inline ms-2 me-2"></span>
                                     <a href="https://web.facebook.com/lsladventuretours.srilanka" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a><span class="vr bg-white d-none d-md-inline ms-2 me-2"></span>
                                    <a href="https://www.tiktok.com/@lsladventuretourslk" target="_blank">
                                        <i class="fa fa-tiktok"></i>
                                    </a><span class="vr bg-white d-none d-md-inline ms-2 me-2"></span>
                                    <a href="https://www.tripadvisor.com/Attraction_Review-g297897-d11660643-Reviews-LSL_Adventure_Tours-Negombo_Western_Province.html" target="_blank">
                                        <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- /Mobile App -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Footer top -->

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p class="mb-lg-0">© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="text-start text-md-end">
                            <ul class="list-inline mb-lg-0">
                                <li class="list-inline-item">
                                    <a href="<?php echo home_url(); ?>/privacy-policy">Privacy Policy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="<?php echo home_url(); ?>/terms-conditions/">Terms & Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Footer Bottom -->

    </footer>
    <!-- /Footer -->

    <!-- Scroll top -->
    <a href="#" class="scroll-top">
        <i class="hicon hicon-thin-arrow-up"></i>
    </a>
    <!-- /Scroll top -->

    <?php wp_footer(); ?>
</body>
</html>