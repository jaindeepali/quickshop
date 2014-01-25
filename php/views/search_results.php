<div class = "pure-g">
<?foreach ($search_results['ebay'] as $key => $value):?>
	<a class="product-ebay pure-u-1-3" href="<?=$value['link']?>">
		<img src="<?=$value['img']?>" >
		<?=$value['title']?><br>
		<?=$value['price']?>
	</a>
<?endforeach;?>
</div>