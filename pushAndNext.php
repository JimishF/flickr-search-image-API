<?php
    set_time_limit(-1);
    error_reporting(0);
    $id_from_src=$_POST["id"];
    $dominantHex=$_POST["dominant_hex"];
    $dominantColor=$_POST["dominant_color"];
    $palleteHex=$_POST["palette_hex"];
    $palleteHex=str_replace("[","",$palleteHex);
    $palleteHex=str_replace("]","",$palleteHex);
    $palleteHex=trim($palleteHex);
    $palleteHexArray=explode(",",$palleteHex);
    foreach($palleteHexArray as $key=>$value){
        $palleteHexArray[$key]=trim($value, '"');
    }
    $palleteColor=$_POST["palette_color"];
    $palleteColor=str_replace("[","",$palleteColor);
    $palleteColor=str_replace("]","",$palleteColor);
    $palleteColor=trim($palleteColor);
    $palleteColorArray=explode(",",$palleteColor);
    for_ideach($palleteColorArray as $key=>$value){
        $palleteColorArray[$key]=trim($value, '"');
    }
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    mysql_select_db('myrangoli');
    $getIdQuery="select `id` from photos where `id_from_src`='".$id_from_src."' LIMIT 1;";
    $IdResult = mysql_query($getIdQuery);
    $id="";
    while($row = mysql_fetch_assoc($IdResult)){
        $id=$row["id"];
    }
    $insQuery="INSERT INTO `img_meta` (`id`, `hex`, `color`, `is_dominant`, `pic_id`) VALUES (NULL, '".$dominantHex."', '".$dominantColor."', '1', '".$id_from_src."');";
    $retval = mysql_query( $insQuery, $conn );
    //echo $i++."Entered data successfully--".$id."<br/>";
    foreach($palleteHexArray as $key=>$value){
        $insPallete="INSERT INTO `img_meta` (`id`, `hex`, `color`, `is_dominant`, `pic_id`) VALUES (NULL, '".$palleteHexArray[$key]."', '".$palleteColorArray[$key]."', '0', '".$id_from_src."');";
        $retval = mysql_query( $insPallete, $conn );
    }
    $getNextIdQuery="select `id_from_src` from photos WHERE id>".$id." LIMIT 1";
    $nextIdResult = mysql_query($getNextIdQuery);
    $nextid="";
    while($nextRow = mysql_fetch_assoc($nextIdResult)){    
        $nextid=$nextRow["id_from_src"];
    }
    echo $nextid;
?>