<div class="panel panel-default">
  <div class="panel-heading"><?php echo $heading_title; ?></div>
  <div class="list-group">
    <form class="price-container box-content" style="text-align: center; width: 85%; margin: 15px auto;">
      <div style="margin: 10px 0px;">
        <?php if ($cur_symbol_side == 'left') { ?><span><?php echo $currency_symbol; ?></span><?php } ?>
        <input type="text" class="form-control price-min" name="price_min" value="<?php echo $lower_limit; ?>" maxlength="<?php echo strlen($upper_limit); ?>" size="5" />
        <?php if ($cur_symbol_side == 'right') { ?><span><?php echo $currency_symbol; ?></span><?php } ?>
        <span>&#8211;</span>
        <?php if ($cur_symbol_side == 'left') { ?><span><?php echo $currency_symbol; ?></span><?php } ?>
        <input type="text" class="form-control price-max" name="price_max" value="<?php echo $upper_limit; ?>" maxlength="<?php echo strlen($upper_limit); ?>" size="5" />
        <?php if ($cur_symbol_side == 'right') { ?><span><?php echo $currency_symbol; ?></span><?php } ?>
      </div>
      <div class="price-slider-container">
        <div class="price-slider"></div>
      </div>
    </form>
  </div>
  <div class="panel-footer text-right">
    <button type="button" class="btn btn-primary reset-button" onclick="Price_Filter.reset();"><?php echo $reset_button; ?></button>
  </div>
</div>
<script type="text/javascript"><!--
  Price_Filter.min = Price_Filter.min || <?php echo $price_min; ?>;
  Price_Filter.max = Price_Filter.max || <?php echo $price_max; ?>;
  Price_Filter.lower_value = Price_Filter.lower_value || <?php echo $lower_limit; ?>;
  Price_Filter.higher_value = Price_Filter.higher_value || <?php echo $upper_limit; ?>;
  Price_Filter.base_url = Price_Filter.base_url || "<?php echo $base_url; ?>";
  Price_Filter.current_path = Price_Filter.current_path || "<?php echo isset($current_path) ? $current_path : ''; ?>";
  Price_Filter.selectors = Price_Filter.selectors || { "container" : "<?php echo !empty($settings['price_filter_container_selector']) ? $settings['price_filter_container_selector'] : '#content .row:nth-last-of-type(2)'; ?>", "paginator" : "<?php echo !empty($settings['price_filter_paginator_selector']) ? $settings['price_filter_paginator_selector'] : '#content .row:nth-last-of-type(1)'; ?>" };
  Price_Filter.empty_message = Price_Filter.empty_message || "<?php echo $empty_message; ?>";

	jQuery(function() {
		if (!Price_Filter.isInitialized) {
			Price_Filter.isInitialized = true;
			if (typeof jQuery.fn.slider === 'undefined') {
				jQuery.getScript('catalog/view/javascript/jquery-ui.slider.min.js', function(){
				jQuery('head').append('<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/jquery-ui.slider.min.css" type="text/css" />');
					Price_Filter.init();
				});
			} else {
				Price_Filter.init();
			}
		}
	});
//--></script>