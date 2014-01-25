<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?=$title?></title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="css/pure-skin-bf.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/ajax.js"></script>
</head>
<body class="pure-skin-bf ">
	<center>
	<div class="pure-g topbar">
		<div class="pure-u-1-2">
			<h1>Title</h1>
		</div>
		<div class="pure-u-1-2">
			<h1>Side</h1>
		</div>
	</div>
	<div id="search">
		<form class="pure-form" action="<?url_for('/')?>" method="post">
			<input type = "text" name = "keyword" placeholder = "Search Product">
			<!-- <input type = "text" name = "brand" placeholder = "Brand (Optional)"> -->
			<!-- <button id = "submit" class = "pure-button">Search</button> -->
			<input type = "submit" value="Submit" class="pure-button">
		</form>
	</div>
	<div class="content">
		<?=$content?>
	</div>
	</center>
</body>
</html>
