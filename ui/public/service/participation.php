<?php 
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 	header("location:/");
}
include 'conn.php';


	$host = $dbhost;
	$db   = 'myrangoli';
	$user = $dbuser;
	$pass = $dbpass;
	$charset = 'utf8';
// "mysql:host=$servername;port=8889;dbname=AppDatabase", $username, $password

	$dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";
try{
	
	$opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$lim_start = $_POST['current'];
	$ar = array();
	$f_ar = array();
	$f_ar['current'] = $lim_start + 16;


	// die($_POST['text']);

	if( trim($_POST['text']) == "" )
	{
	 	$stmt = $pdo->query('SELECT * from photos where photos.source like \'i\' and  del_status = 0  ORDER BY RAND() LIMIT '.$lim_start.','.$f_ar['current'].' ');
		while ($row = $stmt->fetch()){
		    array_push($ar, $row );
		}	
		$f_ar["data"] = $ar;
		
	
	}
	else
	{	

		$text = explode(" ",$_POST['text'] ); 
		$q = 'SELECT * from photos  left join img_meta on img_meta.pic_id = photos.id_from_src  where  photos.source like \'i\' and photos.del_status = 0 and (';
		// $stmt = $pdo->query(


		 for( $i = 0; $i < count($text) ; $i++ ) 
		 {
		 	$q .= "  img_meta.color like '%".$text[ $i ]."%'";
		 	
		 	if( $i !=  count($text)-1 ){
		 		$q .= ' or ';
		 	}else{
		 		$q .= ")";
		 	}
		 }
		 $q .=  "ORDER BY RAND() LIMIT ".$lim_start.",".$f_ar['current'];

		 // echo $q;
		 $stmt = $pdo->query($q);
		 	while ($row = $stmt->fetch()){
		    	array_push($ar, $row );
			}	
			$f_ar["data"] = $ar;

			
	}
				
			header('Content-type: application/json');
			echo json_encode($f_ar);

	// print_r( $text );
	// exit;
	// $stmt = $pdo->query('SELECT * from photos where del_status = 0 ORDER BY RAND() LIMIT 16');

		} catch ( Exception $e ){
			print_r($e);
			echo $e->getMessage();
		}
	
 ?>