<?php
add_action('widgets_init', function () {
    register_sidebar(array(
        'name' => __('Footer Column 1', BORN_NAME),
        'id' => 'footer-column-1',
        'description' => __('', BORN_NAME),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Column 2', BORN_NAME),
        'id' => 'footer-column-2',
        'description' => __('', BORN_NAME),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
    ));

    register_sidebar(array(
        'name' => __('Footer Column 3', BORN_NAME),
        'id' => 'footer-column-3',
        'description' => __('', BORN_NAME),
        'before_widget' => '',
        'after_widget' => '',
    ));
});
