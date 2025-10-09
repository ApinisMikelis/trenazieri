<?php

namespace Born\Widgets;

class BornFooterCopyrights extends \WP_Widget
{

    var $widget_cssclass;
    var $widget_description;
    var $widget_idbase;
    var $widget_name;

    function __construct()
    {
        /* Widget variable settings. */
        $this->widget_cssclass = 'born-footer-copyrights';
        $this->widget_description = esc_html__('Display copyrights and horizontal menu', BORN_NAME);
        $this->widget_idbase = 'born_footer_copyrights';
        $this->widget_name = esc_html__('Born Footer Copyrights', BORN_NAME);

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
        $nav_menu = !empty($instance['nav_menu']) ? $instance['nav_menu'] : false;

        ?>
        <?php echo $args['before_widget']; ?>

        <?php if ($title): ?><span><?php echo $title; ?></span><?php endif; ?>

        <?php if (!empty($nav_menu) && ($menu_obj = wp_get_nav_menu_object($nav_menu)) && $menu_obj->taxonomy === 'nav_menu'):
        $menu_items = wp_get_nav_menu_items($menu_obj);
        ?>
        <ul>
            <?php foreach ($menu_items as $sub_item): ?>
                <?php
                ?>
                <li>
                    <a href="<?php echo $sub_item->url; ?>">
                        <?php echo $sub_item->title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

        <?php echo $args['after_widget']; ?>
        <?php

        $cache = ob_get_flush();

        set_transient($this->id, $cache);
    }


    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = !empty($new_instance['title']) ? $new_instance['title'] : '';
        $instance['nav_menu'] = !empty($new_instance['nav_menu']) ? (int)$new_instance['nav_menu'] : '';

        $this->clear_widget_cache();

        return $instance;
    }


    function clear_widget_cache()
    {
        delete_transient($this->id);
    }


    function form($instance)
    {
        global $wp_customize;
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $nav_menu = !empty($instance['nav_menu']) ? $instance['nav_menu'] : '';
        $menus = wp_get_nav_menus();
        ?>
        <p class="nav-menu-widget-no-menus-message" <?php if (!empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <?php
            if ($wp_customize instanceof WP_Customize_Manager) {
                $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
            } else {
                $url = admin_url('nav-menus.php');
            }
            ?>
            <?php echo sprintf(__('No menus have been created yet. <a href="%s">Create some</a>.'), esc_attr($url)); ?>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', BORN_NAME); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"/>
        </p>

        <div class="nav-menu-widget-form-controls" <?php if (empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu'); ?>"
                        name="<?php echo $this->get_field_name('nav_menu'); ?>">
                    <option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu, $menu->term_id); ?>>
                            <?php echo esc_html($menu->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ($wp_customize instanceof WP_Customize_Manager) : ?>
                <p class="edit-selected-nav-menu" style="<?php if (!$nav_menu_1) {
                    echo 'display: none;';
                } ?>">
                    <button type="button" class="button"><?php _e('Edit Menu') ?></button>
                </p>
            <?php endif; ?>
        </div>

        <?php
    }
}
