<?php if (!defined('WPINC')) die; ?>

<?php
	// Get ACF fields
	$title               = get_field('title');
	$text                = get_field('text');
	$link               = get_field('link');
	$image_id           = get_field('image');
	$youtube_video_url  = get_field('youtube_video_url');
	$video_placeholder  = get_field('video_placeholder_image');
    
    
    $youtube_id = born_extract_youtube_id( $youtube_video_url);
	$rand = rand(1, 1000000);
?>

<div class="tre-single-product-promo">
    <div class="tre-container">
        <div class="inner">

            <!-- Left Side -->
            <div class="left">
                <div class="title">
                    <div class="heading">
						<?php if ($title): ?>
                            <h2>
                                <!-- If you have a custom link function, you can wrap this with <a <?php echo born_acf_link($link); ?> ...> -->
								<?php if ($link): ?>
                                    <a <?php echo born_acf_link($link); ?>>
										<?php echo esc_html($title); ?>
                                    </a>
								<?php else: ?>
									<?php echo esc_html($title); ?>
								<?php endif; ?>
                            </h2>
						<?php endif; ?>
                    </div>
					
					<?php if ($text): ?>
                        <div class="desc">
							<?php echo wp_kses_post($text); ?>
                        </div>
					<?php endif; ?>
					
					<?php if ($link): ?>
                        <div class="cta">
                            <a <?php echo born_acf_link($link); ?> class="tre-button-1">
								<?php echo esc_html($link['title']); ?>
                            </a>
                        </div>
					<?php endif; ?>
                </div>
				
				<?php if ($image_id): ?>
                    <img class="bg" srcset="<?php echo born_acf_image($image_id,'single-promo-banner',false);?>, <?php echo born_acf_image($image_id,'single-promo-banner-x2',false);?>?v=2 2x" alt="<?php echo born_img_alt($image_id); ?>">
				<?php endif; ?>
            </div>

            <!-- Right Side (Video) -->
            <div class="right">
                <div class="video">

                    <div id="thumbnail<?php echo $rand;?>" class="youtube-thumbnail">
						<?php if ($video_placeholder): ?>
                            <img class="bg" srcset="<?php echo born_acf_image($video_placeholder,'single-promo-banner',false);?>, <?php echo born_acf_image($video_placeholder,'single-promo-banner-x2',false);?>?v=2 2x" alt="<?php echo born_img_alt($video_placeholder); ?>">
						<?php endif; ?>

                        <!-- The button triggers a JS function to hide the thumbnail and play the video -->
                        <button onclick="playSingleProductVideo('video<?php echo $rand;?>', 'thumbnail<?php echo $rand;?>')" class="is-play">Play</button>
                    </div>

                    <!-- Iframe source replaced dynamically with the user-provided YouTube link -->
                    <iframe
                            id="video<?php echo $rand;?>"
                            src="https://www.youtube.com/embed/<?php echo $youtube_id;?>"
                            title="YouTube video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                    ></iframe>

                </div>
            </div>

        </div>
    </div>
</div>
