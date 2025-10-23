<?php if (!defined('WPINC')) die; ?>

<?php
	$items = get_field('items'); // Get the title field
    

?>


<div class="tre-intro-banners">
	<div class="inner">
		
		<div class="left">
			
			<div class="item">
				<div class="title">
                    <?php if($items[0]['logo']):?>
					<div class="logo">
						<a <?php echo born_acf_link($items[0]['link']);?>><img src="<?php echo born_acf_image($items[0]['logo'],'large',false);?>" alt="<?php echo born_img_alt($items[0]['logo']);?>"></a>
					</div>
                    <?php endif;?>
					<div class="heading">
                        <?php if($items[0]['subtitle']):?>
                            <div class="subtitle"><?php echo $items[0]['subtitle'];?></div>
                        <?php endif;?>
						<h1><a <?php echo born_acf_link($items[0]['link']);?>><?php echo $items[0]['title'];?></a></h1>
					</div>
                    <?php if($items[0]['link']):?>
					<div class="cta">
						<a <?php echo born_acf_link($items[0]['link']);?> class="tre-button-3"><?php echo $items[0]['link']['title'];?></a>
					</div>
                    <?php endif;?>
				</div>
				<img class="bg" srcset="<?php echo born_acf_image($items[0]['image'],'intro-banners',false);?>, <?php echo born_acf_image($items[0]['image'],'intro-banners-x2',false);?>?v=2 2x" alt="<?php echo $items[0]['title'];?>">
			</div>
		
		</div>
		
		<div class="right">
            
            <?php foreach($items as $key => $item):?>
                <?php if ($key == 0) continue;?>
                <?php $rand = rand(1,9999999);?>
                <div class="item">
                    <div class="title">
	                    <?php if($item['logo']):?>
                            <div class="logo">
                                <a <?php echo born_acf_link($item['link']);?>><img src="<?php echo born_acf_image($item['logo'],'large',false);?>" alt="<?php echo born_img_alt($item['logo']);?>"></a>
                            </div>
	                    <?php endif;?>
                        <div class="heading">
	                        <?php if($item['subtitle']):?>
                                <div class="subtitle"><?php echo $item['subtitle'];?></div>
	                        <?php endif;?>
                            <a <?php echo born_acf_link($item['link']);?>><?php echo $item['title'];?></a>
                        </div>
	                    <?php if($item['link']):?>
                        <div class="cta">
                            <a <?php echo born_acf_link($item['link']);?> class="tre-button-3"><?php echo $item['link']['title'];?></a>
                        </div>
	                    <?php endif;?>
                    </div>
                    <?php if($item['has_video']):?>
                    <div class="bg-video">
                        <script>
                            function showVideo<?php echo $rand;?>() {
                                var element = document.getElementById('tre-intro-banner-video-<?php echo $rand;?>');
                                element.classList.add('is-visible');
                            }
                        </script>
                        <img width="100%" height="100%" srcset="<?php echo born_acf_image($item['image'],'intro-banners',false);?>, <?php echo born_acf_image($item['image'],'intro-banners-x2',false);?>?v=2 2x" alt="<?php echo $item['title'];?>">
                        <video width="100%" height="100%" autoplay loop muted playsinline oncanplaythrough="showVideo<?php echo $rand;?>()" id="tre-intro-banner-video-<?php echo $rand;?>" style="opacity: 0;">
                            <source src="<?php echo $item['video_file'];?>" type="video/mp4">
                            Sorry, your browser doesn't support embedded videos.
                        </video>
                    </div>
                    <?php else:?>
                        <img class="bg" srcset="<?php echo born_acf_image($item['image'],'intro-banners',false);?>, <?php echo born_acf_image($item['image'],'intro-banners-x2',false);?>?v=2 2x" alt="<?php echo $item['title'];?>">
                    <?php endif;?>
                </div>
            
            <?php endforeach;?>
            
		
		</div>
	
	</div>
</div>