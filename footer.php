<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

$schemas_code = get_field('schemas_code',get_the_ID());

$footer_menu_left = born_render_menu([
    'theme_location' => 'footer-menu-left',
    'depth' => 1,
    'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
    'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);

$footer_menu_right = born_render_menu([
    'theme_location' => 'footer-menu-right',
    'depth' => 1,
    'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
    'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);

$footer_brands = get_field('footer_brands', 'options');
?>

</div>
</main>


<footer class="tre-footer">
    <div class="tre-container">
        <div class="inner">

            <div class="row">

                <div class="left">

                    <div class="newsletter">
                        <h2><?php echo born_translation('newsletter_title');?></h2>
                        <form id="mc-newsletter">
                            <div class="input-wrapper">
                                <input type="email" id="email" name="email" placeholder="<?php echo born_translation('newsletter_placeholder');?>" required>
                            </div>
                            <div class="input-wrapper">
                                <input type="submit" value="<?php echo born_translation('newsletter_submit');?>">
                            </div>

                            <div class="mc-success" style="display: none;">
	                            <?php echo born_translation('newsletter_success');?>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="right">
                    <div class="menu">
                        <?php echo $footer_menu_left;?>
                    </div>
                    <div class="menu">
	                    <?php echo $footer_menu_right;?>
                    </div>
                </div>

            </div>

            <div class="row">

                <?php if ($footer_brands):?>
                
                <div class="payment">
                    
                    <?php foreach ($footer_brands as $footer_brand):?>
                        <div>
                            <?php echo born_acf_image($footer_brand,'contacts-icon',true);?>
                        </div>
                    <?php endforeach;?>
                    
                    <div>
                      <a href="https://www.salidzini.lv/" target="_blank">
                          <img
                            style="max-height: 30px;"
                            border="0"
                            alt="Salidzini.lv logotips"
                            title="Lielākais interneta veikalu meklētājs. Atrodi labāko cenu. Mobilie telefoni, Televizori, Portatīvie datori, Sadzīves tehnika"
                            src="https://static.salidzini.lv/images/logo_button.gif"
                          />
                      </a>
                    </div>
                    <div>
                      <a href="https://ceno.lv/" target="_blank">
                        <img
                          src="//cdn.ceno.lv/img/logos/dark-small-retina.png"
                          alt="Ceno.lv"
                          title="Ceno.lv - meklē un salīdzini preču cenas Latvijas interneta veikalos"
                          style="border: none;"
                          width="90"
                          height="30"
                        />
                      </a>
                    </div>
                </div>
                
                <?php endif;?>

            </div>

            <div class="copyright">

                <div class="text">
                    <?php echo born_translation('copyright');?>
                </div>

                <div class="contacts">
                    <ul class="tre-reset">
                        <li class="address"><span><?php echo born_translation('footer_address');?></span></li>
                        <li class="phone"><a href="tel:<?php echo born_translation('footer_phone');?>"><?php echo born_translation('footer_phone');?></a></li>
                        <li class="hours"><a href="mailto:<?php echo born_translation('footer_hours');?>"><?php echo born_translation('footer_hours');?></a></li>
                    </ul>
                </div>

                <a href="http://born.lv" target="_blank" rel="noreferrer" class="made-by-born" title="Web izstrāde BORN DIGITAL">
                    <span><?php echo born_translation('developed_by');?></span>
                    <span class="born-logo">
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                    </span>
                </a>

            </div>

        </div>
    </div>
</footer>

</div>


<?php if ($schemas_code):?>
	<?php echo $schemas_code;?>
<?php endif;?>

<?php

wp_footer();

?>
<script>
    var lazyLoadInstance = new LazyLoad();

    jQuery(window).on('load', function() {

       /* if(jQuery('body.woocommerce-cart, body.product-template-default').length) {
             console.log('HAS CART');
        }*/

       // else {



           // jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"></div><div class="quantity-button quantity-down"></div></div>').insertAfter('.tre-quantity input');

            jQuery('.tre-quantity').each(function() {

                var spinner = jQuery(this),
                    input = spinner.find('input[type="number"]'),
                    btnUp = spinner.find('.quantity-up'),
                    btnDown = spinner.find('.quantity-down'),
                    min = input.attr('min'),
                    max = input.attr('max');

                if (max === "") {
                    max = 999;
                }

                btnUp.click(function() {


                    if (input.val() === "") {
                        var oldValue = 0;
                    }else{
                        var oldValue = parseFloat(input.val());
                    }

                    if (oldValue >= max) {
                        var newVal = oldValue;
                    } else {
                        var newVal = oldValue + 1;
                    }
                    spinner.find('input').val(newVal);
                    spinner.find('input').trigger('change');
                });

                btnDown.click(function() {
                    var oldValue = parseFloat(input.val());
                    if (oldValue <= min) {
                        var newVal = oldValue;
                    } else {
                        var newVal = oldValue - 1;
                    }
                    spinner.find('input').val(newVal);
                    spinner.find('input').trigger('change');
                });

            });

       // }

    });
</script>

<script>
    jQuery(document).ready(function() {
        if (document.querySelector('.cart-discount')) {
            const subtotal = document.querySelector('.cart-subtotal');
            if (subtotal) {
                subtotal.classList.add('has-discount');
            }
        }
    });
</script>