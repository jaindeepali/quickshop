<h1>Stores near you:</h1>
<div class="product">
	<?if(!$stores_results['response']['venues']):?>
		Sorry! No stores found.
	<?endif;?>
	<?foreach ($stores_results['response']['venues'] as $key => $value):?>
		<b><?=$value['name']?></b><br>
		<?foreach ($value['location'] as $k => $val):?>
			<?=$k?>: <?=$val?><br/>
		<?endforeach;?>
	<?endforeach;?><br/><br/>
</div>