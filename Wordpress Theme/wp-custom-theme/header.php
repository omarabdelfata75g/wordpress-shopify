<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding">
                <div class="logo-title">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo"><?php the_custom_logo(); ?></div>
                    <?php else : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php endif; ?>
                    <p class="site-description"><?php echo get_bloginfo('description', 'display'); ?></p>
                </div>
                
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="menu-icon">☰</span>
                </button>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <?php
                // Display the WordPress menu if it exists
                if (has_nav_menu('primary')) :
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                        )
                    );
                else :
                    // Fallback to a basic menu if no menu is set up
                    echo '<ul id="primary-menu" class="menu">';
                    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
                    echo '<li><a href="#">About</a></li>';
                    echo '<li><a href="#">Blog</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/projects/')) . '">Projects</a></li>';
                    echo '<li><a href="#">Contact</a></li>';
                    echo '</ul>';
                endif;
                ?>
            </nav><!-- #site-navigation -->
        </div><!-- .container -->
    </header><!-- #masthead -->