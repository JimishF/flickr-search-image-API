<?php
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db('myrangoli');
    $query = "SELECT * FROM photos";
    $result = mysql_query($query);
    //iterate over all the rows
    while($row = mysql_fetch_assoc($result)){
        //iterate over all the fields
        foreach($row as $key => $val){
            //generate output
            echo $key . ": " . $val."~";
        }
        echo "<br/>";
    }
?>