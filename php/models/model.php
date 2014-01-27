<?php

require ("./libs/scraping/simple_html_dom.php");
//require ("./libs/scraping/ganin.php");
require_once './libs/alchemyapi_php/alchemyapi.php';

class model {
	public $keyword = "";

	public function __construct($param ="")
	{
		$this->keyword = $param;
	}

	public function ebay_get_data()
	{
		// API request variables
		$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
		$version = '1.0.0';  // API version supported by your application
		$appid = option('ebay_app_id');  // Replace with your own AppID
		$globalid = 'EBAY-IN';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
		$safequery = urlencode($this->keyword);  // Make the query URL-friendly

		// Construct the findItemsByKeywords HTTP GET call
		$apicall = "$endpoint?";
		$apicall .= "OPERATION-NAME=findItemsByKeywords";
		$apicall .= "&SERVICE-VERSION=$version";
		$apicall .= "&SECURITY-APPNAME=$appid";
		$apicall .= "&GLOBAL-ID=$globalid";
		$apicall .= "&keywords=$safequery";
		//$apicall .= "&paginationInput.entriesPerPage=15";

		// Load the call and capture the document returned by eBay API
		$resp = simplexml_load_file($apicall);

		// Check to see if the request was successful, else print an error
		if ($resp->ack == "Success") {
		  $results = array();
		  // If the response was loaded, parse it and build links
		  foreach($resp->searchResult->item as $item) {
		  	$result = array();
		    $result['img']   = $item->galleryURL;
		    $result['link']  = $item->viewItemURL;
		    $result['title'] = $item->title;
		    $result['price'] = $item->sellingStatus->currentPrice;
		    $results[] = $result;
		  }
		}
		// If the response does not indicate 'Success,' print an error
		else {
		  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
		  $results .= "AppID for the Production environment.</h3>";
		}

		return $results;
	}

	public function amazon_get_data()
	{
		// Create DOM from URL or file
		$page = 1;
		$html = new simple_html_dom();
		$safequery = urlencode($this->keyword);

		// Load HTML from a URL 
		//$html->load_file('http://www.google.com/');
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
		//var_dump($products);
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
		//$html->load_file('http://www.google.com/');
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
		//var_dump($products);
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
		//$html->load_file('http://www.google.com/');
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
		//var_dump($products);
		if(isset($products))
			return $products;
		else
			return NULL;
	}

	public function find_stores()
	{
		//require_once './libs/vendor/autoload.php';
		//use Jcroll\FoursquareApiClient\Client\FoursquareClient;
		$alchemyapi = new AlchemyAPI();

		// $client = FoursquareClient::factory(array(
		//     'client_id'     => option('foursquare_client_id'),    // required
		//     'client_secret' => option('foursquare_client_secret') // required
		// ));

		$response = $alchemyapi->category('text',$this->keyword, null);
		if($response['category']=="unknown")
			$response['category'] = $this->keyword;
		else
			$response['category'] .= " ".$this->keyword;
		option('category',$response['category']);
		//option('category','coffee');
		require_once './libs/foursquare.php';

		// //$client->addToken($oauthToken); // optionaly pass in for user specific requests
		// $command = $client->getCommand('venues/search', array(
		//     'near' => 'New Delhi, India',
		//     'query' => $response['category'];
		// ));
		// $results = $command->execute(); // returns an array of results

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
		// var_dump($score);
		// var_dump($sentiment);
		$score = floatval($score);
		// var_dump($score);
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