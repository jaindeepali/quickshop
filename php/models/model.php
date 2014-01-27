<?php

require ("./libs/scraping/simple_html_dom.php");
require_once './libs/alchemyapi_php/alchemyapi.php';

class model {
	public $keyword = "";

	public function __construct($param ="")
	{
		$this->keyword = $param;
	}

	public function amazon_get_data()
	{
		// Create DOM from URL or file
		$page = 1;
		$html = new simple_html_dom();
		$safequery = urlencode($this->keyword);

		// Load HTML from a URL 
		$html ->load_file('http://www.amazon.in/s/ref=sr_pg_'.$page.'?rh=i%3Aaps%2Ck%3A'.$safequery.'&page=2&keywords='.$safequery.'&ie=UTF8&qid=1390657044');
		$i=0;
		foreach($html->find('div.prod') as $product) {
		    $item['title'] = $product->find('h3.newaps', 0)->plaintext;
		    if($product->find('ul li.newp span.bld', 0))
		    	$item['price'] = $product->find('ul li.newp span.bld', 0)->plaintext;
		   	else
		   		$item['price'] = $product->find('.price', 0)->plaintext;
		    $item['img'] = $product->find('div.imageBox img', 0)->src;
		    $item['link'] = $product->find('h3.newaps a', 0)->href;
		    $products[] = $item;
		    if($i == 6)
		    	break;
		    $i++;
		}
		if(isset($products))
			return $products;
		else
			return NULL;
	}

	public function flipkart_get_data()
	{
		// Create DOM from URL or file
		$page = 1;
		$html = new simple_html_dom();
		$safequery = urlencode($this->keyword);

		// Load HTML from a URL 
		$html ->load_file('http://www.flipkart.com/search?q='.$safequery);
		$i = 0;
		foreach($html->find('div.product-unit') as $product) {
		    $item['title'] = $product->find('div.pu-title', 0)->plaintext;
		    $item['price'] = $product->find('div.pu-final', 0)->plaintext;
			if(isset($product->find('div.pu-visual-section img', 0)->attr['data-src']))
		    	$imageData = $product->find('div.pu-visual-section img', 0)->attr['data-src'];
		    else
		    	$imageData = $product->find('div.pu-visual-section img', 0)->attr['src'];
		    $item['img'] = urldecode($imageData);
		    $item['link'] = 'http://www.flipkart.com'.$product->find('div.pu-visual-section a', 0)->href;
		    $products[] = $item;
		    if($i == 6)
		    	break;
		    $i++;
		}
		if(isset($products))
			return $products;
		else
			return NULL;
	}

	public function snapdeal_get_data()
	{
		// Create DOM from URL or file
		$page = 1;
		$html = new simple_html_dom();
		$safequery = urlencode($this->keyword);

		// Load HTML from a URL 
		$html ->load_file('http://www.snapdeal.com/search?keyword='.$safequery.'&santizedKeyword=&catId=1&categoryId=12&suggested=false&vertical=&noOfResults=10&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&cityPageUrl=&url=&utmContent=&catalogID=&dealDetail=');

		$i = 0;
		if($html->find('div.product_grid_cont')){
			foreach($html->find('div.product_grid_cont') as $product) {
			    $item['title'] = $product->find('div.product_grid_cont_heading', 0)->plaintext;
			    $item['price'] = $product->find('div.product_price span.originalprice', 0)->plaintext;
			    $item['img'] = $product->find('div.product-image img', 0)->lazysrc;
			    $item['link'] = $product->find('a', 0)->href;
			    $products[] = $item;
			    if($i == 6)
			    	break;
			    $i++;
			}
		}
		else{
			foreach($html->find('div.product_listing_cont') as $product) {
			    $item['title'] = $product->find('div.product_listing_heading', 0)->plaintext;
			    $item['price'] = $product->find('div.product_price span.originalprice', 0)->plaintext;
			    $item['img'] = $product->find('div.product-image img', 0)->lazysrc;
			    $item['link'] = $product->find('a', 0)->href;
			    $products[] = $item;
			    if($i == 6)
			    	break;
			    $i++;
			}
		}
		if(isset($products))
			return $products;
		else
			return NULL;
	}

	public function find_stores()
	{
		$alchemyapi = new AlchemyAPI();
		$response = $alchemyapi->category('text',$this->keyword, null);
		if($response['category']=="unknown")
			$response['category'] = $this->keyword;
		else
			$response['category'] .= " ".$this->keyword;
		option('category',$response['category']);
		require_once './libs/foursquare.php';
		return option('stores');
	}

	public function add_comment($table, $comment)
	{
		global $link;
		$score = 0;
		$alchemyapi = new AlchemyAPI();
		$response = $alchemyapi->sentiment('text',$comment, null);
		if ($response['status'] == 'OK') {
		 	$sentiment = $response['docSentiment']['type'];
		 	if (array_key_exists('score', $response['docSentiment'])) {
		 		$score = $response['docSentiment']['score'];
		 	}
		 }
		$score = floatval($score);
		$result = mysqli_query($link, "INSERT INTO $table (`comment`,`score`) VALUES ('$comment', $score)");
		if(!$result)
			echo mysqli_error($link);
	}

	public function get_analysis($table)
	{
		global $link;
		$data = array();
		$flipkart_result = mysqli_query($link, "SELECT AVG(`score`) FROM Flipkart");
		$snapdeal_result = mysqli_query($link, "SELECT AVG(`score`) FROM Snapdeal");
		$amazon_result = mysqli_query($link, "SELECT AVG(`score`) FROM Amazon");
		$row = mysqli_fetch_assoc($flipkart_result);
		$data['flipkart_score'] = floatval($row["AVG(`score`)"]);
		$data['flipkart_analysis'] = $this->analyze($data['flipkart_score']);
		$row = mysqli_fetch_assoc($snapdeal_result);
		$data['snapdeal_score'] = floatval($row["AVG(`score`)"]);
		$data['snapdeal_analysis'] = $this->analyze($data['snapdeal_score']);
		$row = mysqli_fetch_assoc($amazon_result);
		$data['amazon_score'] = floatval($row["AVG(`score`)"]);
		$data['amazon_analysis'] = $this->analyze($data['amazon_score']);
		$flipkart_result = mysqli_query($link, "SELECT * FROM Flipkart");
		$i = 0;
		while($row = mysqli_fetch_assoc($flipkart_result))
		{
			$data['flipkart_comments'][$i] = $row; 
			$i++;
		}
		$snapdeal_result = mysqli_query($link, "SELECT * FROM Snapdeal");
		$i = 0;
		while($row = mysqli_fetch_assoc($snapdeal_result))
		{
			$data['snapdeal_comments'][$i] = $row; 
			$i++;
		}
		$amazon_result = mysqli_query($link, "SELECT * FROM Amazon");
		$i = 0;
		while($row = mysqli_fetch_assoc($amazon_result))
		{
			$data['amazon_comments'][$i] = $row; 
			$i++;
		}
		return $data;
	}

	public function analyze($score)
	{
		$result = "";
		if($score == 0)
			$result = "It is as good an option as anything else.";
		else if($score > 0 && $score <= 0.5)
			$result = "People like this website.";
		else if($score > 0.5 && $score <= 1)
			$result = "Wow! This is the best choice ever!";
		else if($score < 0 && $score >= -0.5)
			$result = "You probably should look for a better option.";
		else if($score < -0.5 && $score >= -1)
			$result = "Worst choice ever.";
		return $result;
	}
}