<?php
/**
 * The template for displaying all single posts
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
                <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <header class="entry-header">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span> | 
                            <span class="post-author">By <?php the_author(); ?></span>
                        </div>
                    </header>

                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        // Display categories and tags
                        $categories_list = get_the_category_list(', ');
                        if ($categories_list) {
                            echo '<div class="post-categories">Categories: ' . $categories_list . '</div>';
                        }
                        
                        $tags_list = get_the_tag_list('', ', ');
                        if ($tags_list) {
                            echo '<div class="post-tags">Tags: ' . $tags_list . '</div>';
                        }
                        ?>
                    </footer>
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