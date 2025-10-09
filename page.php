<?php

get_header();

if (!is_front_page()){
	get_template_part('layout/partials/page-title');
}



?>

<?php

while ( have_posts() ) {
    the_post();
    the_content();
}

get_footer();

?>
