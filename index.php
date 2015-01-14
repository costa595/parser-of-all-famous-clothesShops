<?php
ini_set("max_execution_time", 0);
include("connect.php");
include("getImageColor.php");
include("constants.php");

// $query = $DBH->query("SELECT price,id FROM clothes");

// $query->setFetchMode(PDO::FETCH_ASSOC); 

// while ($qu=$query->fetch()) 
// {	

	
// 		$str = str_replace('</del> ', iconv('windows-1251', 'UTF-8', 'руб.'), $qu['price']);
// 		$str = str_replace('<del> ', '', $str);
// 		// echo $str;
// 		echo $st = iconv('UTF-8', 'windows-1251', $str);

// 		$q = $DBH->prepare("UPDATE clothes SET price = '".$st."' WHERE id = ".$qu['id']);
// 		$q->execute();
	 
	
// }

?>

<html>

<head>
	<title>
		App name
    </title>
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/raphael.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>

<body>

<div id="wrapper">

	<div id="header"></div>

	<div id="main_block">

		<? 
						//-----------------------------------SETTING GENDER---------------
			if($_GET['sex']=='m') 
			{
				$color='#00FF00';
				$text_color='#228B22';
				$string = 'Мужскую';
				$sex = " AND sex = 'm' ";

			}  elseif($_GET['sex']=='w') {

				$color='#FFD700';
				$text_color='#FF8C00';
				$string = 'Женскую';
				$sex = " AND sex = 'w' ";

			} else {

				$color = '#40E0D0';
				$text_color='#4169E0';
				$sex = " ";
				$search_items_string = " ";
			}

							//-----------------------------------NOTHING CHOSEN---------------
			if(!isset($_GET['category']))
			{
					?> <h1 >Выбрать</h1> <?

					switch ($_GET['sex']) 
					{
						case 'm' or'w':
							echo $string;
							?>
								<hr align="center" width="400px" size="2" color="<?echo $color?>" />

								<ul class="category" style="font-size:25px;">
									<a href="?category=shoes&sex=<?echo $_GET['sex']?>">
										<li id="shoes">
											<div class="category_block">
												<img src="images/main_categories/<?echo $_GET['sex']?>_shoes.png">
												<br>
												Обувь
											</div>	
										</li>
									</a>
									<a href="?category=clothes&sex=<?echo $_GET['sex']?>">
										<li id="clothes">
											<div class="category_block">
												<img src="images/main_categories/<?echo $_GET['sex']?>_clothes.png">
												<br>
												Одежду	
											</div>
										</li>
									</a>
									<a href="?category=accs&sex=<?echo $_GET['sex']?>">
										<li id="accs">
											<div class="category_block">
												<img src="images/main_categories/<?echo $_GET['sex']?>_accs.png">
												<br>
												Аксессуары	
											</div>
										</li>
									</a>
								</ul>

								<hr align="center" width="400px" size="2" color="<?echo $color?>" />

							<?
						break;
						
						default:
							?>
								<hr align="center" width="200px" size="2" color="#DC143C" />

								<ul class="sex">
									<a href="?sex=m">
										<li id="man">
											Мужское	
										</li>
									</a>
									<a href="?sex=w" style="margin-left:30px;">
										<li id="woman">
											Женское
										</li>
									</a>
								</ul>

								<hr align="center" width="200px" size="2" color="#DC143C" />
							<?
						break;
					}

			} else {

					//------------------------------------------CHOOSING TYPE---------------

					?> <h1 style="font-size:45px;">Выбрать</h1> <?

					//----------------SETTING QUERY STRING--------------------

					switch ($_GET['category']) 
					{
						case 'shoes':
							$after_string = 'Обувь';

							$search_items_arr = array_merge($shoes_types_arr, $shoes_types_sport_arr,$shoes_types_classic_arr);

							$search_items_string = iconv('windows-1251', 'UTF-8', 'AND type IN ("'.implode('","',$search_items_arr).'") ');
						break;
						
						case 'clothes':
							$after_string = 'Одежду';

							$search_items_arr = array_merge($clothes_types_down_arr, $clothes_types_top_arr,$clothes_types_underwear_top_arr,$clothes_types_underwear_down_arr, $clothes_outfit_arr, $clothes_swimming_arr,$clothes_types_top_classic_arr,$clothes_types_down_classic_arr);

							$search_items_string = iconv('windows-1251', 'UTF-8', 'AND type IN ("'.implode('","',$search_items_arr).'") ');
						break;

						case 'accs':
							$after_string = 'Аксессуары';

							$search_items_arr = array_merge($accs_types_jewellery_arr, $accs_hats_arr,$accs_neck_arr,$accs_in_hands_arr,$accs_betl_arr,$accs_arr);

							$search_items_string = iconv('windows-1251', 'UTF-8', 'AND type IN ("'.implode('","',$search_items_arr).'") ');
						break;
					}
							//------------TOP MENU------------
					?>
						<hr align="center" width="200px" size="2" color="<?echo $color?>" />

						<div class="title_string">
							<?
							if($string!=NULL)
								{
							?>
									<span class="name" style="border:1px solid <?echo $color?>;">
										<?echo $string;?>
									</span> 
									 >  
							<? 
								} 
							?>	
							<span class="name" style="border:1px solid <?echo $color?>;">
								<?echo $after_string;?>
							</span>
						</div>

						<hr align="center" width="200px" size="2" color="<?echo $color?>" />

					<?

					$query_str = $sex.$search_items_string.' LIMIT 12';
					
					$select_items = $DBH->query('SELECT * FROM clothes WHERE 1'.$query_str);

					$select_items->setFetchMode(PDO::FETCH_ASSOC);  

					?>

					<div id="photo_block" style="border:2px dashed <?echo $color;?>; border-top:2px solid #ffffff; height:1050px;" >

					<?

						while ($item=$select_items->fetch()) 
						{
							?>	
								<ul class="items">
									<?
									if(($item['src']!='')) 
										{
									?>
											<li>
												<div class="item_block">
													<img src="<?echo $item['src']?>">
													<span class="type">
														<?echo iconv('UTF-8', 'windows-1251', $item['type']).' '.iconv('UTF-8', 'windows-1251', $item['brand']);?>
													</span>
													<br>
													<span class="sizes">
														<?echo iconv('UTF-8', 'windows-1251', $item['sizes']);?>
													</span>
													<br>
													<b>
														<span class="price" style="color:<?echo $text_color;?>">
															<?echo iconv('UTF-8', 'windows-1251', $item['price']).'руб.';?>
														</span>
													</b>
												</div>
											</li>
									<? 
										} 
									?>
								</ul>
							<?
						}
					?>

					</div>

					<?
			}	
			

		?>

	</div>
																	<!--HEADER-->
	<div id="line"></div>

																   <!--PERSON_BLOCK-->
	<div id="person_block">


		<div id="person">

			<img src="images/women.jpg" id="human">
			
			<!-- <img src="images/woman.jpg" id="human"> -->

			<div id="head" class="info_square">
				<img src="<?php echo $head;?>" width="100%;" height="100%;" >
			</div>

			<div id="canvas_container"></div>

			 <div id="head_accs" class="info_square">
				<img src="<?echo $head_accs;?>" width="100%;" height="100%;">
			</div> 

			<div id="neck_accs" class="info_square">
				<img src="<?echo $neck_accs;?>" width="100%;" height="100%;">
			</div>

			<div id="neck" class="info_square">
				<img src="<?echo $neck;?>" width="100%;" height="100%;">
			</div>

			<div id="chest" class="info_square">
				<img src="<?echo $chest;?>" width="100%;" height="100%;">
			</div>

			<div id="hand_jewellery" class="info_square">
				<img src="<?echo $hand_jew;?>" width="100%;" height="100%;">
			</div>

			<div id="hand_accs" class="info_square">
				<img src="<?echo $hand_accs;?>" width="100%;" height="100%;">
			</div>

			<div id="belt" class="info_square">
				<img src="<?echo $belt;?>" width="100%;" height="100%;">
			</div>

			 <div id="hands" class="info_square">
				<img src="<?echo $hands;?>" width="100%;" height="100%;">
			</div>

			<div id="legs" class="info_square">
				<img src="<?echo $legs;?>" width="100%;" height="100%;">
			</div>

			<div id="feet" class="info_square">
				<img src="<?echo $feet;?>" width="100%;" height="100%;">
			</div> 

			<a href="?item=random">Random</a>

		</div>

	</div>
															<!--FOOTER-->
	<div id="footer">

	</div>

	<script type="text/javascript">
										//----------LINES---------------

		    var ph = document.getElementById("canvas_container");
            var paper = Raphael(ph);
            var head = paper.path("M 415 70 L 675 10").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var head_accs = paper.path("M 120 20 L 380 90").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var neck_accs = paper.path("M 130 120 L 390 140").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var neck = paper.path("M 675 150 L 390 120").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var chest = paper.path("M 530 250 L 410 180").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var hand_jewellery = paper.path("M 260 220 L 340 240").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var hand_accs = paper.path("M 260 370 L 340 240").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var belt = paper.path("M 530 390 L 400 230").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var legs = paper.path("M 530 530 L 410 290").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var gloves = paper.path("M 260 510 L 340 240").attr({stroke: "#aaa", "stroke-dasharray": "- "});
            var shoes = paper.path("M 360 710 L 360 530").attr({stroke: "#aaa", "stroke-dasharray": "- "});

	</script>
</div>

</body>

</html>
