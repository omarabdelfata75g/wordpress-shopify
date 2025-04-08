<?php
/**
 * The template for displaying single project posts
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
                <article id="post-<?php the_ID(); ?>" <?php post_class('project'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="project-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <header class="entry-header">
                        <h1 class="project-title"><?php the_title(); ?></h1>
                        <div class="project-meta">
                            <span class="project-date"><?php echo get_the_date(); ?></span>
                        </div>
                    </header>

                    <div class="project-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        // Display project categories if they exist
                        $project_terms = get_the_terms(get_the_ID(), 'project_category');
                        if ($project_terms && !is_wp_error($project_terms)) {
                            echo '<div class="project-categories">Categories: ';
                            $term_names = array();
                            foreach ($project_terms as $term) {
                                $term_names[] = '<a href="' . esc_url(get_term_link($term)) . '">' . $term->name . '</a>';
                            }
                            echo implode(', ', $term_names);
                            echo '</div>';
                        }
                        ?>
                    </footer>
                </article>

                <div class="project-navigation">
                    <div class="nav-previous"><?php previous_post_link('%link', '&larr; Previous Project'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Next Project &rarr;'); ?></div>
                </div>
            <?php
            endwhile; // End of the loop.
            ?>
        </main><!-- #main -->

        <?php get_sidebar(); ?>
    </div><!-- .container -->
</div><!-- .site-content -->

<?php
get_footer();