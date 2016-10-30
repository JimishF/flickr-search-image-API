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
	$lim_start = $_POST['current'];
	$ar = array();
	$f_ar = array();
	$f_ar['current'] = $lim_start + 16; 
	// $stmt = $pdo->query('SELECT * from photos where del_status = 0 ORDER BY RAND() LIMIT 16');
	$stmt = $pdo->query('SELECT * from photos where del_status = 0 LIMIT '.$lim_start.','.$f_ar['current'].' ');
		while ($row = $stmt->fetch())
		{
		    array_push($ar, $row );
		}

	// foreach ($ar as $key => $value) {
	// 	# code...
	// }
	// print_r( $ar );

	$f_ar["data"] =$ar;
		header('Content-type: application/json');
		echo json_encode($f_ar);
	// exit;
 ?>