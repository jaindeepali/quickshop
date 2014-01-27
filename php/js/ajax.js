$(document).ready(function(){
	$("#store").unbind('click').click(function(){
		event.preventDefault();
		if (window.XMLHttpRequest) xmlhttp = new XMLHttpRequest();
	    else xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

	    xmlhttp.open("GET","http://ipinfo.io/json",false);
	    xmlhttp.send();

	    hostipInfo = xmlhttp.responseText;
	    var ip = JSON.parse(hostipInfo);
		var keyword = $("#prod").val();
		$('.content').html("<img src='./public/images/ajax-loader.gif'>");
		$.ajax({
		  type: "get",
		  url: "/myprojects/bloomfilter/php/?/stores/"+keyword,
		  data:{
		  	ipinfo: ip,
		  },
		  datatype: "text",
		  success: function(response){
		  	$('.content').append("<img src='./public/images/ajax-loader.gif'>");
		  	$('.content').html(response);
		  },
		  error: function(){
		    console.log("something has gone wrong");
		  }
		});
	});
	$("#add_comment").unbind('click').click(function(){
		event.preventDefault();
		var table = $("#table").val();
		var comment = $("#comm").val();
		$('.result').empty();
		$('.result').append("<img src='./public/images/ajax-loader.gif'>");
		//console.log(table);
		$.ajax({
			type:"post",
			url: "/myprojects/bloomfilter/php/?/comment/",
			data:{
				table: table,
				comment: comment,
			},
		  success: function(response){
		  	console.log(response);
		  	$('.result').empty();
		  	$('.result').html(response);
		  	$('#comm').val("");
		  },
		  error: function(){
		    console.log("something has gone wrong");
		  }
		});
	});
	$("#analysis").unbind('click').click(function(){
		event.preventDefault();
		$.ajax({
		  url: "/myprojects/bloomfilter/php/?/analysis/",
		  datatype: "text",
		  success: function(response){
		  	console.log(response);
		  	$('.content').html(response);
		  },
		  error: function(){
		    console.log("something has gone wrong");
		  }
		});
	});
	$(function(){
			$('table').visualize();
	});

});