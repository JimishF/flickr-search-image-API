<?php 

	$host = '127.0.0.1';
	$db   = 'myrangoli';
	$user = 'root';
	$pass = '';
	$charset = 'utf8';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$id = $_POST['ref_id'];
	if( isset($_POST['donot'])){
		$stmt = $pdo->prepare('UPDATE photos set del_status = 0 where id = :idx');	
	}
	else{
		$stmt = $pdo->prepare('UPDATE photos set del_status = 1 where id = :idx');
	}
	$stmt->bindParam( ":idx", $id, PDO::PARAM_INT );

		if( $stmt->execute() ){
			echo "yes";
		}else{
			echo "no";
		}

	// foreach ($ar as $key => $value) {
	// 	# code...
	// }
	// print_r( $ar );
		// header('Content-type: application/json');
		// echo json_encode($ar);
	// exit;
 ?>