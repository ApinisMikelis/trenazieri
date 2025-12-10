<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

$schemas_code = get_field('schemas_code',get_the_ID());

$footer_categories_menu_1 = born_render_menu([
  'theme_location' => 'footer-categories-menu-1',
  'depth' => 1,
  'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
  'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);

$footer_categories_menu_2 = born_render_menu([
  'theme_location' => 'footer-categories-menu-2',
  'depth' => 1,
  'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
  'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);

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

                    <div class="menu">
                        <?php echo $footer_categories_menu_1;?>
                    </div>

                    <div class="menu">
                        <?php echo $footer_categories_menu_2;?>
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