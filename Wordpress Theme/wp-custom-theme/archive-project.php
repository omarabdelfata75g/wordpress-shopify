<?php
/**
 * The template for displaying project archives
 */

// Include WordPress header template
require_once(TEMPLATEPATH . '/header.php');
?>

<div class="site-content">
    <div class="container">
        <main id="main" class="content-area">
            <header class="page-header">
                <h1 class="page-title">Projects</h1>
                <div class="archive-description">
                    <p>Browse our portfolio of projects.</p>
                </div>
            </header><!-- .page-header -->

            <?php if (have_posts() && function_exists('have_posts')) : ?>
                <div class="projects-grid">
                    <?php
                    // Start the Loop
                    while (have_posts() && function_exists('have_posts')) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('project'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <header class="entry-header">
                                <h2 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            </header>

                            <div class="project-excerpt">
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>" class="read-more">View Project</a>
                            </div>
                        </article>
                    <?php
                    endwhile;
                    ?>
                </div><!-- .projects-grid -->

                <?php
                // Previous/next page navigation
                the_posts_pagination(array(
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                ));
            else :
                ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </main><!-- #main -->

        <?php get_sidebar(); ?>
    </div><!-- .container -->
</div><!-- .site-content -->

<?php
get_footer();