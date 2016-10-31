<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 	header("location:/");
}
	include 'conn.php';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass,'myrangoli') or die(mysqli_error($conn));


	$STATE = $_POST['state_data'];
	$id = $STATE['res']['id'];
	$url = $STATE['res']['url'];
	$sq_url = $STATE['res']['sq_url'];
	

	$GET = array();
	parse_str($_POST['f_data'], $GET);

	$title = $GET['text'];
	$dominantHex = $STATE['colorData']['dominantHex'];
	$dominantColor = $STATE['colorData']['dominantColor'];
	$id_from_src = $id;

	$theme = "";
	if( isset($GET['ganesha']) ){
		$theme .= 'ganesha | ';
	}
	if( isset($GET['cndia']) ){
		$theme .= 'cndia | ';
	}
	if( isset($GET['thm_text']) ){
		$theme .= 'thm_text | ';
	}
	if( isset($GET['peacock']) ){
		$theme .= 'peacock';
	}


	if( isset($GET['wupdate'])){
		$GET['wupdate'] = '1';
	}else{
		$GET['wupdate'] = '0';
	}

	$mysqli = new mysqli($dbhost, $dbuser, $dbpass,'myrangoli');

	$uEntryQ =  "INSERT INTO `user_data` ( `first_name`, `last_name`, `email`, `phone`, `bday`, `city`, `pin`, `wupdate`, `study`) VALUES  ('".$GET['first_name'] ."','".$GET['last_name']."','".$GET['email']."','".$GET['phone']."','".$GET['bdate']."','".$GET['city']."','".$GET['pin']."','".$GET['wupdate']."','".$GET['study']."')";
		$u_id =	mysqli_query( $conn, $uEntryQ );


		$result = $mysqli->query($uEntryQ);
		$u_id = $mysqli->insert_id;


	$imgEntryQ = "INSERT INTO `photos`(`id`, `id_from_src`,`title`, `imgUrl`, `source`, `sq_url`,`theme`,`u_id`) VALUES (NULL,'".$id_from_src ."','".$title."','".$url."','i','".$sq_url."','".$theme."','".$u_id."')";
	mysqli_query( $conn, $imgEntryQ );



	$insQuery="INSERT INTO `img_meta` (`id`, `hex`, `color`, `is_dominant`, `pic_id`) VALUES (NULL, '".$dominantHex."', '".$dominantColor."', '1', '".$id_from_src."');";
	mysqli_query( $conn, $insQuery);


	foreach ($STATE['colorData']['paletteColorArray'] as $key => $value)
	{
		
		 $insQuery="INSERT INTO `img_meta` (`id`, `hex`, `color`, `is_dominant`, `pic_id`) VALUES (NULL, '".$STATE['colorData']['paletteHex'][$key]."', '".$value."', '0', '".$id_from_src."');";
		mysqli_query( $conn, $insQuery);
		 
	}
	// $stmt = $pdo->query('SELECT * from photos where del_status = 0 ORDER BY RAND() LIMIT 16');


	// $stmt = $pdo->query('SELECT * from photos where del_status = 0 LIMIT '.$lim_start.','.$f_ar['current'].' ');
	// 	while ($row = $stmt->fetch())
	// 	{
	// 	    array_push($ar, $row );
	// 	}

	// // foreach ($ar as $key => $value) {
	// // 	# code...
	// // }
	// // print_r( $ar );

	// $f_ar["data"] =$ar;
	// 	header('Content-type: application/json');
		// echo json_encode($f_ar);
	// exit;
	echo "done";
	
// } catch (Exception $e) {
// 	print_r($e);
// 	echo $e->getMessage();
// }
 ?>