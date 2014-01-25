<div class = "pure-g">
	<div class="pure-u-1-3 pure-g">
	<h2>Snapdeal</h2>
	<?foreach ($search_results['snapdeal'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				<b><?=$value['price']?></b><br></div>
			</a>
		</div>
	<?endforeach;?>
	</div>
	<div class="pure-u-1-3 pure-g">
	<h2>Amazon</h2>
	<?foreach ($search_results['amazon'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				</div>
			</a>
		</div>
	<?endforeach;?>
	</div>
	<div class="pure-u-1-3 pure-g">
	<h2>Flipkart</h2>
	<?foreach ($search_results['flipkart'] as $key => $value):?>
		<div class="product-snapdeal product">
			<a href="<?=$value['link']?>">
				<div class="pure-u-1-4"><center><img src="<?=$value['img']?>" ></center></div>
				<div class="pure-u-3-4"><?=$value['title']?><br>
				<b><?=$value['price']?></b><br></div>
			</a>
		</div>
	<?endforeach;?>
	</div>
</div>