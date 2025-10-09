<?php

namespace Born\Core;


if (!defined('ABSPATH')) {
    exit;
}

class Comments extends \Walker_Comment
{

    /**
     * Outputs a single comment.
     *
     * @param WP_Comment $comment Comment to display.
     * @param int $depth Depth of the current comment.
     * @param array $args An array of arguments.
     * @see wp_list_comments()
     *
     * @since 3.6.0
     *
     */
    protected function comment($comment, $depth, $args)
    {
        $tag = 'li';

        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'comment parent' : 'comment', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment the-comment">
            <div class="comment-avatar">
                <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
            </div>

            <div class="comment-content">
                <div class="comment-meta">
					<span class="comment-author">
						<span><?php echo get_comment_author($comment); ?></span>
					</span>
                </div>

                <div class="text">
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
                    <?php endif; ?>

                    <div class="comment-text">
                        <?php comment_text(); ?>
                    </div>
                </div>


                <div class="comment-meta">
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>" class="comment-time">
                        <time><?php echo sprintf(_x('Pirms %s', 'Time format', BORN_NAME), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?></time>
                    </a>
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<span class="reply">',
                        'after' => '</span>'
                    )));
                    ?>
                </div>


            </div>
        </article><!-- .comment-body -->
        <?php
    }

}