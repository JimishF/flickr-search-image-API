<?php
    set_time_limit(-1);
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db('myrangoli');
    $query = "SELECT * FROM `photos`";
    $result = mysql_query($query);
    //iterate over all the rows
    $i=1;
    while($row = mysql_fetch_assoc($result)){
        $id=$row["id_from_src"];
        $url=str_replace("_z","_q",$row["imgUrl"]);

        echo $i++."-".$url."<br/>";
        $img=file_get_contents($url);
        file_put_contents("./res/imgs/".$id.".jpg",$img);
    }
?>