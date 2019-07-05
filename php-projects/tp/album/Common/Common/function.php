<?php
function mkImgLink($dir,$key,$ext,$size='big'){
    if($size=='orig'){
        return $dir.'/'.$key.'.'.$ext;
    }
    return $dir.'/'.$key.'_'.$size.'.'.$ext;
}

function html_replace($str){
    $str = stripslashes($str);
    $str = str_replace('&','&amp;',$str);
    $str = str_replace('\'','&#039;',$str);
    $str = str_replace('"','&quot;',$str);
    $str = str_replace('<','&lt;',$str);
    $str = str_replace('>','&gt;',$str);
    $str = addslashes($str);
    return $str;
}