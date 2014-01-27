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
	$data['flipkart'] = $model->flipkart_get_data();
	$data['amazon'] = $model->amazon_get_data();
	$data['snapdeal'] = $model->snapdeal_get_data();
	set('search_results', $data);
	return render('search_results.php');
}

function find_stores($keyword)
{
	option('ipinfo',$_GET['ipinfo']);
	$model = new model($keyword);
	$data = array();
	$data = $model->find_stores();
	set('stores_results', $data);
	return render('stores_result.php', null);
}

function add_comment()
{
	$table = $_POST['table'];
	$comment = $_POST['comment'];
	$model = new model($table);
	$model->add_comment($table, $comment);
	echo "Added";
}

function analysis()
{
	$model = new model();
	$data = $model->get_analysis();
	set('analysis_results', $data);
	return render('analysis_result.php', null);
}