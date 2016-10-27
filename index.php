<?php
    set_time_limit(-1);
    function httpGet($url)
    {
        $ch = curl_init();  
    
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    //  curl_setopt($ch,CURLOPT_HEADER, false); 
    
        $output=curl_exec($ch);
    
        curl_close($ch);
        return $output;
    }
    
$text = "rangoli design";
for($i=1; $i<=21; $i++)
{
    $file_data  =  httpGet("https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=38bd8b2ec53acd8812a8d2069711cfd9&text=diwali+Rangoli&per_page=&page=".$i."&format=json&nojsoncallback=1"); 
    file_put_contents("./res/".$text."_".$i.".json",$file_data);
}   

?>