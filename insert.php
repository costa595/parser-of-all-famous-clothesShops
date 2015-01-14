<?php  

ini_set("max_execution_time", 0);

include("simple_html_dom.php");
include("connect.php");

function check($a)
{
	if($a==NULL)
	{
		$string = '';
	} else {
		$string = $a;
	}

	return $string;
}

$item_to_find = 'accs';


for($x=1; $x<82; $x++)
{
	$src_arr = array();
	$sizes_arr = array();
	$label_info_arr = array();
	$brand_info_arr = array();
	$type_info_arr = array();
	$price_info_arr = array();

	$infos = file_get_html('parsed/women/'.$item_to_find.'/'.$x.'.html');

	$k=1;

	if(count($infos->find('.products-list-item')))
	{
		foreach ($infos->find('.products-list-item .product-label') as $label_info) 
		{
			$result = check($label_info->plaintext);

			$label_info_arr[] = $result;
		}

		foreach ($infos->find('.products-list-item .products-list-item__brand') as $brand_info) 
		{
			$result = check($brand_info->plaintext);

			$brand_info_arr[] = $result;
		}

		foreach ($infos->find('.products-list-item .products-list-item__type') as $type_info) 
		{
			$result = check($type_info->plaintext);

			$type_info_arr[] = $result;
		}

		foreach ($infos->find('.products-list-item .price') as $price_info) 
		{
			$result = check($price_info->plaintext);

			$price_info_arr[] = $result;
		}

		foreach ($infos->find('.products-list-item__img') as $img) 
		{
			$src_arr[] = $img->src;
		}

		foreach ($infos->find('.products-list-item .products-list-item__sizes') as $sizes_info) 
		{
			$sizes_tmp = array();
			while($size = $sizes_info->children($k++))
			{
				$sizes_tmp[] = $size->plaintext;
			}
			$sizes_arr[] = $sizes_tmp;
			$k=1;
		}	

	} else {echo "not found";}

	$query = $DBH->prepare("INSERT INTO accs_w(label, brand, type, price, src, sizes, shop, sex) VALUES (?,?,?,?,?,?,?,?)");

	$shop = 'lamoda.ru';
	$tmp_str = '';
	$sex = 'w';

	foreach ($sizes_arr as $key => $size_arr) 
	{
		$query->bindParam(1, $label_info_arr[$key]);
		$query->bindParam(2, $brand_info_arr[$key]);
		$query->bindParam(3, $type_info_arr[$key]);
		$query->bindParam(4, $price_info_arr[$key]);
		$query->bindParam(5, $src_arr[$key]);

		foreach ($size_arr as $key2 => $size_value) 
		{
			$tmp_str .= ','.$size_value; 
		}

		$query->bindParam(6,$tmp_str);
		
		$query->bindParam(7, $shop);
		$query->bindParam(8, $sex);

		// $query->execute();

		$tmp_str = '';
	}

	// var_dump($sizes_arr);


	$infos->clear(); 
	unset($infos);
}


?>