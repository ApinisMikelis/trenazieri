<?php

namespace Born\Widgets;

class BornFooterAbout extends \WP_Widget
{

    var $widget_cssclass;
    var $widget_description;
    var $widget_idbase;
    var $widget_name;

    function __construct()
    {
        /* Widget variable settings. */
        $this->widget_cssclass = 'logo';
        $this->widget_description = esc_html__('Display logo and description', BORN_NAME);
        $this->widget_idbase = 'born_footer_about';
        $this->widget_name = esc_html__('Born Footer About', BORN_NAME);

        /* Widget settings. */
        $widget_ops = array('classname' => $this->widget_cssclass, 'description' => $this->widget_description);

        /* Add Widget scripts */
        add_action('admin_enqueue_scripts', array($this, 'scripts'));

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

        $image = !empty($instance['image']) ? $instance['image'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';

        ?>
        <?php echo $args['before_widget']; ?>

        <?php if ($image): ?>
        <a href="/">
            <img src="<?php echo esc_url($image); ?>" alt="">
        </a>
    <?php endif; ?>
        <?php if ($description): ?>
        <a href="/">
            <?php echo $description; ?>
        </a>
    <?php endif; ?>

        <?php echo $args['after_widget']; ?>
        <?php

        $cache = ob_get_flush();

        set_transient($this->id, $cache);
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['description'] = $new_instance['description'];
        $instance['image'] = (!empty($new_instance['image'])) ? $new_instance['image'] : '';

        $this->clear_widget_cache();

        return $instance;
    }

    function clear_widget_cache()
    {
        delete_transient($this->id);
    }

    function form($instance)
    {
        $image = !empty($instance['image']) ? $instance['image'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>"
                   name="<?php echo $this->get_field_name('image'); ?>" type="text"
                   value="<?php echo esc_url($image); ?>"/>

            <button class="upload_image_button button button-primary"
                    style="margin-top: 5px;"><?php _e('Upload Image', BORN_NAME); ?></button>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:', BORN_NAME); ?></label>
            <textarea class="widefat"
                      name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_html($description); ?></textarea>
        </p>

        <?php
    }

    public function scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_media();
        wp_enqueue_script('born-admin', get_template_directory_uri() . '/assets/js/admin/image-upload.js', array('jquery'));
    }
}
