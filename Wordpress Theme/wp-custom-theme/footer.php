<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-widget">
                    <h3>About Us</h3>
                    <p>This is a custom WordPress theme created for demonstration purposes. It features a responsive design, custom post types, and dynamic navigation.</p>
                </div>
                <div class="footer-widget">
                    <h3>Quick Links</h3>
                    <?php
                    // Display footer menu if it exists
                    if (has_nav_menu('footer')) :
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'container'      => false,
                            )
                        );
                    else :
                        // Fallback to a basic menu
                        echo '<ul id="footer-menu" class="menu">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
                        echo '<li><a href="#">Privacy Policy</a></li>';
                        echo '<li><a href="#">Terms of Service</a></li>';
                        echo '</ul>';
                    endif;
                    ?>
                </div>
                <div class="footer-widget">
                    <h3>Contact Info</h3>
                    <p>Email: info@example.com<br>
                    Phone: (123) 456-7890<br>
                    Address: 123 WordPress Lane, Web City</p>
                </div>
            </div><!-- .footer-widgets -->
            
            <div class="footer-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="footer-logo"><?php the_custom_logo(); ?></div>
                <?php endif; ?>
                <div class="footer-title">
                    <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
                </div>
            </div><!-- .footer-branding -->
            
            <div class="site-info">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
            </div><!-- .site-info -->
        </div><!-- .container -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Navigation functionality is handled by navigation.js -->

</body>
</html>