<?php
	global $router, $db;
	include_once('../exponent.php');
	/*
	
	

*/
$cats = getCategories();

foreach($cats as $cat) {    

	$sc = $db->selectObject("storeCategories", "id ='{$cat->ProductCategoryID}'");

	if($cat->ProductCategoryDescription == "inactive" && !empty($sc->id)) {
		$sc->is_active = 0;
		$db->updateObject($sc, "storeCategories");
	}
	//Record already exist
	if(!empty($sc->id)) {
		$sc->title    = $cat->ProductCategoryName;
		$sc->sef_url = $router->encode($sc->title);
		$db->updateObject($sc, "storeCategories");
	} else {
		$sc = "";
		$sc->id       = $cat->ProductCategoryID;
		$sc->title    = $cat->ProductCategoryName;
		$sc->is_active = 1;
		$sc->sef_url = str_replace("+", "plus", $router->encode($sc->title));
		$db->insertObject($sc, "storeCategories");
	}
	/*
	echo "<pre>";
	print_r($rec);
	exit();
	$sc = new storeCategory();
	$sc->id       = $cat->ProductCategoryID;
	$sc->title    = $cat->ProductCategoryName;
	$sc->is_active = 1;
	$sc->sef_url = $router->encode($sc->title);
	$sc->save();
	*/
}

$products = getProducts(null, true);
$db->delete("product_storeCategories", "1=1");

foreach($products as $item) {    
	
	$sc = $db->selectObject("product", "id ={$item->ProductID}");
	
	
	if(!empty($sc->id)) {
		$sc->title   = $item->ProductDescription;
		$sc->body    = $item->ProductLongDescription;	
		$sc->sef_url = str_replace("+", "plus", $router->encode($sc->title));
		$sc->model   = $item->ProductSKU;
		$sc->base_price   = $item->ProductSellingPrice * 1.05;
		$sc->special_price   = $item->ProductSellingPrice;
		$sc->use_special_price   = 1;
		$sc->product_type   = "product";
		$sc->is_featured    = $item->ProductVersion;
		$sc->manufacturing_price = $item->ProductMainSupplierPrice;
		$db->updateObject($sc, "product");
	} else {
		$sc = "";
		$sc->id      = $item->ProductID;
		$sc->title   = $item->ProductDescription;
		$sc->body    = $item->ProductLongDescription;
		$sc->sef_url = str_replace("+", "plus", $router->encode($sc->title)) ;
		$sc->model   = $item->ProductSKU;
		$sc->base_price   = $item->ProductSellingPrice * 1.05;
		$sc->special_price   = $item->ProductSellingPrice;
		$sc->use_special_price   = 1;
		$sc->product_type   = "product";
		$sc->is_featured    =  $item->ProductVersion;
		$sc->manufacturing_price = $item->ProductMainSupplierPrice;
		$db->insertObject($sc, "product");
	}
	
	
	
	
	$obj = "";
	$obj->storecategories_id = $item->ProductCategoryID;
	$obj->product_id         = $item->ProductID;
	$obj->product_type       = "product";
	$obj->rank       		 = 0;
	
	$db->insertObject($obj, "product_storeCategories");

}



echo "ok!";
	
	function getCategories() {
		$arr = "";
		$arr['APIKEY'] = "c8c3ec7f1b65dc9d@m11394";	
		$arr['query'] = "mv.ProductCategoryID != 0 ORDER BY mv.ProductCategoryName";
		$str = json_encode($arr);


		$ch = curl_init();
		$headers = array('Accept: application/json','Content-Type: application/json'); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_URL,"http://api.megaventory.com//v2/json/reply/ProductCategoryGet?format=json");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$str);


		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		$res = json_decode($server_output);

		curl_close ($ch);

		return $res->mvProductCategories;
	}
	
	function getProducts($productID = "", $includeReferencedObjects = false) {
		$arr = "";
		$arr['APIKEY'] = "c8c3ec7f1b65dc9d@m11394";	
		$arr['includeReferencedObjects'] = $includeReferencedObjects;
		$query = "";
		if($productID != "") {
			$query = "mv.ProductID = {$productID}";
		}
		$arr['query'] = $query;
		$str = json_encode($arr);


		$ch = curl_init();
		$headers = array('Accept: application/json','Content-Type: application/json'); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_URL,"http://api.megaventory.com//v2/json/reply/ProductGet?format=json");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$str);


		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		$res = json_decode($server_output);
		
		curl_close ($ch);
		return $res->mvProducts;
	}
?>