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

    $file=files("res");
    $i=1; 
    foreach($file as $f){
        $data=file_get_contents("res/".$f);
        $json=json_decode($data,true);
        //print_r($json["photos"]["photo"][0]["id"]);
        foreach($json["photos"]["photo"] as $value){
            $id=$value["id"];
            $owner=$value["owner"];
            $secret=$value["secret"];
            $server=$value["server"];
            $farm=$value["farm"];
            $title=mysql_real_escape_string($value["title"]);
            $imgUrl="https://farm".$farm.".staticflickr.com/".$server."/".$id."_".$secret."_z.jpg";
            $query="INSERT INTO `photos` (`id`, `id_from_src`, `owner`, `secret`, `server`, `title`, `imgUrl`) VALUES (NULL, '".$id."', '".$owner."', '".$secret."', '".$server."', '".$title."', '".$imgUrl."');";
            try{
                $retval = mysql_query( $query, $conn );
                echo $i++."Entered data successfully--".$id."<br/>";
            }
            catch(Exception $e){
                continue;
            }
            
        }
    }
    
    mysql_close($conn);

    function files($path,&$files = array())
    {
        $dir = opendir($path."/.");
        while($item = readdir($dir))
            if(is_file($sub = $path."/".$item))
                $files[] = $item;else
                if($item != "." and $item != "..")
                    files($sub,$files); 
        return($files);
    }
?>