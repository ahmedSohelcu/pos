<?php

//function isNavActive($path, $active = 'menu-open'){
//    return call_user_func_array('Request::is', (array)$path) ? $active : '';
//}

function isNavActive($path,$active='active menu-open'){
    if(!is_array($path)){
        $path=substr($path,1,strlen($path)).'*';
        $active='active';
    }
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}



function getUrlsFromRouteNames($names){
    $paths=[];
    foreach ($names->toArray() as $name){
        $path=route($name,[],false).'*';
        array_push($paths,substr($path,1,strlen($path)));
    }
    return $paths;
}
