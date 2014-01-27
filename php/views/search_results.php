<div class = "pure-g">
	<div class="pure-u-1-3 pure-g">
	<h1>Snapdeal</h1>
	<?if($search_results['snapdeal']):?>
	<?foreach ($search_results['snapdeal'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				<b><?=$value['price']?></b><br></div>
			</a>
		</div>
	<?endforeach;?>
	<?endif;?>
	</div>
	<div class="pure-u-1-3 pure-g">
	<h1>Amazon</h1>
	<?if($search_results['amazon']):?>
	<?foreach ($search_results['amazon'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				<b><?=$value['price']?></b><br></div>
			</a>
		</div>
	<?endforeach;?>
	<?endif;?>
	</div>
	<div class="pure-u-1-3 pure-g">
	<h1>Flipkart</h1>
	<?if($search_results['flipkart']):?>
	<?foreach ($search_results['flipkart'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				<b><?=$value['price']?></b><br></div>
			</a>
		</div>
	<?endforeach;?>
	<?endif;?>
	</div>
</div>
