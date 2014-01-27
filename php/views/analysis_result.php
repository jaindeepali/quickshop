<h1>Sentiment Analysis based people's comments.</h1>
<table class="pure-table">
	<thead>
	        <tr>
	            <th>Website</th>
	            <th>Score</th>
	            <th>Analysis</th>
	        </tr>
	    </thead>

	    <tbody>
	        <tr>
	            <td>Flipkart</td>
	            <td><?=$analysis_results['flipkart_score']?></td>
	            <td><?=$analysis_results['flipkart_analysis']?></td>
	        </tr>

	        <tr>
	            <td>Snapdeal</td>
	            <td><?=$analysis_results['snapdeal_score']?></td>
	            <td><?=$analysis_results['snapdeal_analysis']?></td>
	        </tr>

	        <tr>
	            <td>Amazon</td>
	            <td><?=$analysis_results['amazon_score']?></td>
	            <td><?=$analysis_results['amazon_analysis']?></td>
	        </tr>
	    </tbody>
</table>
<div>
	<h1>Comments:</h1>
	<div class="pure-g">
		<div class="pure-u-1-3">
		<h2>Flipkart</h2><br>
		<?foreach($analysis_results['flipkart_comments'] as $value):?>
			<?=$value['Comment']?><br/>
		<?endforeach;?>
		</div>
		<div class="pure-u-1-3">
		<h2>Snapdeal</h2><br>
		<?foreach($analysis_results['snapdeal_comments'] as $value):?>
			<?=$value['Comment']?><br/>
		<?endforeach;?>
		</div>
		<div class="pure-u-1-3">
		<h2>Amazon</h2><br>
		<?foreach($analysis_results['amazon_comments'] as $value):?>
			<?=$value['Comment']?><br/>
		<?endforeach;?>
		</div>
	</div>
</div>