<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        <main id="main" class="content-area">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <header class="entry-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile; // End of the loop.
            ?>
        </main><!-- #main -->

        <?php get_sidebar(); ?>
    </div><!-- .container -->
</div><!-- .site-content -->

<?php
get_footer();