<?php

namespace Born\Widgets;

class BornFooterSocial extends \WP_Widget
{

    var $widget_cssclass;
    var $widget_description;
    var $widget_idbase;
    var $widget_name;

    function __construct()
    {
        /* Widget variable settings. */
        $this->widget_cssclass = 'born-footer-social';
        $this->widget_description = esc_html__('Display social icons with links', BORN_NAME);
        $this->widget_idbase = 'born_footer_social';
        $this->widget_name = esc_html__('Born Footer Social', BORN_NAME);

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
            echo $cache;
            return;
        }

        ob_start();
        extract($args);

        $title = !empty($instance['title']) ? $instance['title'] : '';
        $social_flags = array_keys(born_get_social_networks());

        ?>
        <?php echo $args['before_widget']; ?>
        <?php echo '<div class="social">'; ?>

        <?php if ($title): ?><span><?php echo $title; ?></span><?php endif; ?>

        <?php foreach ($social_flags as $flag) {
        if ($link = \Born\Options\Options::get('social_' . $flag)) {
            echo '<a href="' . $link . '"><i class="fab fa-' . $flag . '"></i></a>';
        }
    }
        ?>

        <?php echo '</div>'; ?>
        <?php echo $args['after_widget']; ?>
        <?php

        $cache = ob_get_flush();

        set_transient($this->id, $cache);
    }


    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = !empty($new_instance['title']) ? $new_instance['title'] : '';

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
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', BORN_NAME); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"/>
        </p>

        <?php
    }
}
