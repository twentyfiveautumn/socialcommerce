<?php
	/**
	 * Elgg input - product type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 **/ 
	
	$class = isset($vars['class'])? $vars['class'] : "input-product-type" ;
	$options_values = array();
		foreach(elgg_get_config('product_type_default') as $key) {
			$options_values[$key->value] = $key->display_val;
		}
?>
	<div>
		<label for="product_type_id"><?php echo elgg_echo('product:type');?>:</label>
		<?php echo elgg_view('input/dropdown', array(
			'name' => 'product_type_id',
			'id' => 'product_type_id',
			'class' => $class,
			'value' => $vars['value'],
			'options_values' => $options_values,
			));
		?>
	</div>
