<?php

namespace Born\Widgets;

class BornFooterSubscribe extends \WP_Widget
{

    var $widget_cssclass;
    var $widget_description;
    var $widget_idbase;
    var $widget_name;

    function __construct()
    {
        /* Widget variable settings. */
        $this->widget_cssclass = 'born-footer-subscribe';
        $this->widget_description = esc_html__('Display MailChimp subscribe form', BORN_NAME);
        $this->widget_idbase = 'born_footer_subscribe';
        $this->widget_name = esc_html__('Born Footer Subscribe', BORN_NAME);

        /* Widget settings. */
        $widget_ops = array('classname' => $this->widget_cssclass, 'description' => $this->widget_description);

        /* Create the widget. */
        parent::__construct(
            $this->widget_idbase,
            $this->widget_name,
            $widget_ops
        );

        add_action('save_post', array($this, 'clear_widget_cache'));
        add_action('deleted_post', array($this, 'clear_widget_cache'));
        add_action('switch_theme', array($this, 'clear_widget_cache'));
    }


    function widget($args, $instance)
    {
        $cache = get_transient($this->id);

        if ($cache) {
            echo $args['before_widget'];
            echo '<form class="form-mailchimp">';

            echo $cache;

            echo born_get_nonce_field('born_mailchimp_subscribe');
            echo '</form>';
            echo $args['after_widget'];

            return;
        }

        echo $args['before_widget'];
        echo '<form class="form-mailchimp">';

        ob_start();
        extract($args);

        $title = !empty($instance['title']) ? $instance['title'] : '';
        $terms = !empty($instance['terms']) ? $instance['terms'] : '';
        ?>

        <?php if ($title): ?><label><?php echo $title; ?></label><?php endif; ?>

        <div class="form-fields">
            <div class="input-wrapper is-inline success-msg">
                <label><?php _e('You have been successfully subscribed to our newsletter!', BORN_NAME); ?></label>
            </div>

            <div class="input-wrapper is-inline hide-on-success">
                <input type="text" name="email" placeholder="<?php esc_attr_e('Your e-mail address', BORN_NAME); ?>">
                <input type="submit" name="submit" value="<?php esc_attr_e('Subscribe', BORN_NAME); ?>"
                       disabled="disabled">
            </div>
            <span data-related="email" class="field-err"><?php _e('Invalid email address!', BORN_NAME); ?></span>

            <div class="input-wrapper is-checkbox hide-on-success">
                <input type="checkbox" id="<?php echo $this->id; ?>-terms" name="terms">
                <label for="<?php echo $this->id; ?>-terms"><?php echo $terms; ?></label>
            </div>
        </div>

        <input type="hidden" name="action" value="born_subscribe">
        <?php

        $cache = ob_get_flush();

        // avoid nonce caching
        echo born_get_nonce_field('born_mailchimp_subscribe');
        echo '</form>';
        echo $args['after_widget'];

        set_transient($this->id, $cache);
    }


    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = !empty($new_instance['title']) ? $new_instance['title'] : '';
        $instance['terms'] = !empty($new_instance['terms']) ? $new_instance['terms'] : '';

        $this->clear_widget_cache();

        return $instance;
    }


    function clear_widget_cache()
    {
        delete_transient($this->id);
    }


    function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $terms = !empty($instance['terms']) ? $instance['terms'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', BORN_NAME); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('terms')); ?>"><?php esc_html_e('Terms & Conditions label:', BORN_NAME); ?></label>
            <textarea class="widefat"
                      name="<?php echo esc_attr($this->get_field_name('terms')); ?>"><?php echo esc_html($terms); ?></textarea>
        </p>

        <?php
    }
}
