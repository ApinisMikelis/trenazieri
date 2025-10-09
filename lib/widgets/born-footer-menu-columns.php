<?php

namespace Born\Widgets;

class BornFooterMenuColumns extends \WP_Widget
{

    var $widget_cssclass;
    var $widget_description;
    var $widget_idbase;
    var $widget_name;

    public function __construct()
    {
        /* Widget variable settings. */
        $this->widget_cssclass = 'menu';
        $this->widget_description = esc_html__('Display menus by columns', BORN_NAME);
        $this->widget_idbase = 'born_footer_menu_columns';
        $this->widget_name = esc_html__('Born Footer Menu Columns', BORN_NAME);

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

    public function widget($args, $instance)
    {
        $cache = get_transient($this->id);

        if ($cache) {
            echo $cache;
            return;
        }

        ob_start();
        extract($args);

        echo $args['before_widget'];

        for ($i = 1; $i < 5; $i++) {
            $suffix = '_' . $i;
            $title_handle = 'title' . $suffix;
            $nav_menu_handle = 'nav_menu' . $suffix;

            $nav_menu = !empty($instance[$nav_menu_handle]) ? wp_get_nav_menu_object($instance[$nav_menu_handle]) : false;

            // skip if nothing selected
            if (!$nav_menu) {
                continue;
            }

            echo '<div>';
            $title = !empty($instance[$title_handle]) ? $instance[$title_handle] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);

            if ($title) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            if (!empty($nav_menu) && ($menu_obj = wp_get_nav_menu_object($nav_menu)) && $menu_obj->taxonomy === 'nav_menu'):
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
            <?php endif;
            echo '</div>';
        }
        echo $args['after_widget'];

        $cache = ob_get_flush();

        set_transient($this->id, $cache);
    }


    public function update($new_instance, $old_instance)
    {
        $instance = array();

        for ($i = 1; $i < 5; $i++) {
            $suffix = '_' . $i;
            $title_handle = 'title' . $suffix;
            $nav_menu_handle = 'nav_menu' . $suffix;

            if (!empty($new_instance[$title_handle])) {
                $instance[$title_handle] = sanitize_text_field($new_instance[$title_handle]);
            }

            if (!empty($new_instance[$nav_menu_handle])) {
                $instance[$nav_menu_handle] = (int)$new_instance[$nav_menu_handle];
            }
        }

        $this->clear_widget_cache();

        return $instance;
    }


    function clear_widget_cache()
    {
        delete_transient($this->id);
    }


    public function form($instance)
    {
        global $wp_customize;
        $title_1 = !empty($instance['title_1']) ? $instance['title_1'] : '';
        $nav_menu_1 = !empty($instance['nav_menu_1']) ? $instance['nav_menu_1'] : '';

        $title_2 = !empty($instance['title_2']) ? $instance['title_2'] : '';
        $nav_menu_2 = !empty($instance['nav_menu_2']) ? $instance['nav_menu_2'] : '';

        $title_3 = !empty($instance['title_3']) ? $instance['title_3'] : '';
        $nav_menu_3 = !empty($instance['nav_menu_3']) ? $instance['nav_menu_3'] : '';

        $title_4 = !empty($instance['title_4']) ? $instance['title_4'] : '';
        $nav_menu_4 = !empty($instance['nav_menu_4']) ? $instance['nav_menu_4'] : '';

        // Get menus
        $menus = wp_get_nav_menus();

        // If no menus exists, direct the user to go and create some.
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
        <div class="nav-menu-widget-form-controls" <?php if (empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <p>
                <label for="<?php echo $this->get_field_id('title_1'); ?>"><?php _e('Menu 1 title:') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title_1'); ?>"
                       name="<?php echo $this->get_field_name('title_1'); ?>"
                       value="<?php echo esc_attr($title_1); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu_1'); ?>"><?php _e('Select Menu 1:'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu_1'); ?>"
                        name="<?php echo $this->get_field_name('nav_menu_1'); ?>">
                    <option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu_1, $menu->term_id); ?>>
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
        <hr/>


        <div class="nav-menu-widget-form-controls" <?php if (empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <p>
                <label for="<?php echo $this->get_field_id('title_2'); ?>"><?php _e('Menu 2 title:') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title_2'); ?>"
                       name="<?php echo $this->get_field_name('title_2'); ?>"
                       value="<?php echo esc_attr($title_2); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu_2'); ?>"><?php _e('Select Menu 2:'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu_2'); ?>"
                        name="<?php echo $this->get_field_name('nav_menu_2'); ?>">
                    <option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu_2, $menu->term_id); ?>>
                            <?php echo esc_html($menu->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ($wp_customize instanceof WP_Customize_Manager) : ?>
                <p class="edit-selected-nav-menu" style="<?php if (!$nav_menu_2) {
                    echo 'display: none;';
                } ?>">
                    <button type="button" class="button"><?php _e('Edit Menu') ?></button>
                </p>
            <?php endif; ?>
        </div>
        <hr/>


        <div class="nav-menu-widget-form-controls" <?php if (empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <p>
                <label for="<?php echo $this->get_field_id('title_3'); ?>"><?php _e('Menu 3 title:') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title_3'); ?>"
                       name="<?php echo $this->get_field_name('title_3'); ?>"
                       value="<?php echo esc_attr($title_3); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu_3'); ?>"><?php _e('Select Menu 3:'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu_3'); ?>"
                        name="<?php echo $this->get_field_name('nav_menu_3'); ?>">
                    <option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu_3, $menu->term_id); ?>>
                            <?php echo esc_html($menu->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ($wp_customize instanceof WP_Customize_Manager) : ?>
                <p class="edit-selected-nav-menu" style="<?php if (!$nav_menu_3) {
                    echo 'display: none;';
                } ?>">
                    <button type="button" class="button"><?php _e('Edit Menu') ?></button>
                </p>
            <?php endif; ?>
        </div>
        <hr/>


        <div class="nav-menu-widget-form-controls" <?php if (empty($menus)) {
            echo ' style="display:none" ';
        } ?>>
            <p>
                <label for="<?php echo $this->get_field_id('title_4'); ?>"><?php _e('Menu 4 title:') ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title_4'); ?>"
                       name="<?php echo $this->get_field_name('title_4'); ?>"
                       value="<?php echo esc_attr($title_4); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nav_menu_4'); ?>"><?php _e('Select Menu 4:'); ?></label>
                <select id="<?php echo $this->get_field_id('nav_menu_4'); ?>"
                        name="<?php echo $this->get_field_name('nav_menu_4'); ?>">
                    <option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu_4, $menu->term_id); ?>>
                            <?php echo esc_html($menu->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ($wp_customize instanceof WP_Customize_Manager) : ?>
                <p class="edit-selected-nav-menu" style="<?php if (!$nav_menu_4) {
                    echo 'display: none;';
                } ?>">
                    <button type="button" class="button"><?php _e('Edit Menu') ?></button>
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
}
