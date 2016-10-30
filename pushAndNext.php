<?php
    set_time_limit(-1);
    error_reporting(0);
    $id_from_src=$_POST["id"];
    $dominantHex=$_POST["dominant_hex"];
    $dominantColor=$_POST["dominant_color"];
    $palleteHex=mysql_real_escape_string($_POST["palette_hex"]);
    $palleteColor=mysql_real_escape_string($_POST["palette_color"]);
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
    $insQuery="INSERT INTO `img_meta` (`id`, `hex_dominant`, `color_dominant`, `is_dominant`, `hex_palette`, `color_palette`, `pic_id`) VALUES (".$id.", '".$dominantHex."', '".$dominantColor."', '1', '".$palleteHex."', '".$palleteColor."', '".$id_from_src."');";
    $retval = mysql_query( $insQuery, $conn );
    //echo $i++."Entered data successfully--".$id."<br/>";
    $getNextIdQuery="select `id_from_src` from photos WHERE id>".$id." LIMIT 1";
    $nextIdResult = mysql_query($getNextIdQuery);
    $nextid="";
    while($nextRow = mysql_fetch_assoc($nextIdResult)){    
        $nextid=$nextRow["id_from_src"];
    }
    echo $nextid;
?>