<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?=$title?></title>
  <!-- <link rel="stylesheet" href="css/reset.css"> -->
  <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="css/colorbox.css">
  <link rel="stylesheet" href="css/pure-skin-bf.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/colorbox-master/jquery.colorbox.js"></script>
  <script>
  	$(document).ready(function(){
  		$(".inline").colorbox({inline:true, width:"50%"});
  	});
  </script>
  <script type="text/javascript" src="js/ajax.js"></script>
</head>
<body class="pure-skin-bf">
	<center>
	<div class="pure-g topbar">
		<div class="pure-u-1-3 title">
			<a href="<?=url_for('/');?>"><h1><b><i class="fa fa-shopping-cart fa-2x" style="color:#91B399;"></i> QuickShop</b></h1></a>
		</div>
		<div class="pure-u-2-3" style="margin-top:50px">
			<a class='inline pure-button' href="#inline_content"><i class="fa fa-edit"></i> Add Comments</a>
			<a class='pure-button' id="analysis"><i class="fa fa-bar-chart-o"></i> View Analysis</a>
		</div>
	</div>
	<div id="search">
		<form class="pure-form" action='<?=url_for('/search')?>' method="post">
			<input type = "text" id = "prod" name = "keyword" placeholder = "Search Product">
			<input type = "submit" value="Compare" class="pure-button">
			<span id="store" class="pure-button">Find on nearby stores!</span>
		</form>
	</div>
	<div class="content">
		<?=$content?>
	</div>
	<div style='display:none'>
		<div id='inline_content' style='padding:10px; background:#fff;'>
		<center>
			<form class="pure-form">
				<input name="table"  type="text" placeholder="Website" id="table"><br><br>
				<textarea id = "comm" name = "comment" placeholder = "Comment" rows="5" cols="50"></textarea><br><br>
				<span id="add_comment" class="pure-button">Add</span>
				<span class="result"></span>
			</form>
		</center>
		</div>
	</div>
	</center>
</body>
</html>
