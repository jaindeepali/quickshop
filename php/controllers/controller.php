<?php

function home()
{
		return render('home.php');
}

function search()
{
	$keyword = $_POST['keyword'];
	$model = new model($keyword);
	$data = array();
	$data['ebay'] = $model->ebay_get_data();
	// $data['flipkart'] = $model->flipkart_get_data();
	// $data['amazon'] = $model->amazon_get_data();
	// $data['snapdeal'] = $model->snapdeal_get_data();
	// $data['foursquare'] = $model->foursquare_get_data();
	set('search_results', $data);
	return render('search_results.php');
}
