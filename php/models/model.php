<?php

require ("./libs/scraping/simple_html_dom.php");

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
		$html ->load_file('http://www.amazon.in/s/ref=sr_pg_'.$page.'?rh=i%3Aaps%2Ck%3A'.$this->keyword.'&page=2&keywords='.$safequery.'&ie=UTF8&qid=1390657044');

		foreach($html->find('div.prod') as $product) {
		    $item['title'] = $product->find('h3.newaps', 0)->plaintext;
		    $item['price'] = $product->find('ul', 0)->plaintext;
		    $item['img'] = $product->find('div.imageBox img', 0)->src;
		    $item['link'] = $product->find('h3.newaps a', 0)->href;
		    $products[] = $item;
		}
		//var_dump($products);
		return $products;
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

		foreach($html->find('div.product-unit') as $product) {
		    $item['title'] = $product->find('div.pu-title', 0)->plaintext;
		    $item['price'] = $product->find('div.pu-final', 0)->plaintext;
		    $imageData = $product->find('div.pu-visual-section img', 0)->attr['data-src'];
		    $item['img'] = urldecode($imageData);
		    $item['link'] = 'http://www.flipkart.com'.$product->find('div.pu-visual-section a', 0)->href;
		    $products[] = $item;
		}
		//var_dump($products);
		return $products;
	}

	public function snapdeal_get_data()
	{
		// Create DOM from URL or file
		$page = 1;
		$html = new simple_html_dom();
		$safequery = urlencode($this->keyword);

		// Load HTML from a URL 
		//$html->load_file('http://www.google.com/');
		$html ->load_file('http://www.snapdeal.com/search?keyword='.$safequery.'&santizedKeyword=&catId=1&categoryId=12&suggested=true&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&cityPageUrl=&url=&utmContent=&catalogID=&dealDetail=');

		foreach($html->find('div.product_grid_cont') as $product) {
		    $item['title'] = $product->find('div.product_grid_cont_heading', 0)->plaintext;
		    $item['price'] = $product->find('div.product_price span.originalprice', 0)->plaintext;
		    $item['img'] = $product->find('div.product-image img', 0)->lazysrc;
		    $item['link'] = $product->find('a', 0)->href;
		    $products[] = $item;
		}
		//var_dump($products);
		return $products;
	}
}