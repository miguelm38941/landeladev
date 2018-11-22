<?php

function clean_string_special($string) {
   $string = str_replace(' ', '#', $string); // Replaces all spaces with hyphens.

   $string = preg_replace('/[^A-Za-z0-9\-\#]/', '', $string); // Removes special chars.
   $string = str_replace('#', ' ', $string); // Replaces all spaces with hyphens.

	return $string;
}

function clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function strpos_array($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false) return $pos;
    }
    return false;
}

function stripos_array($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = stripos($haystack, $what))!==false) return $pos;
    }
    return false;
}

function startsWith($haystack, $needle){

    if(is_string($haystack) == false) return false;

    if(!is_array($needle)) $needle = array($needle);

    foreach($needle as $n){
        $length = strlen($n);
        if(strtolower(substr($haystack, 0, $length)) === strtolower($n))
            return true;
    }

    return false;
}

function endsWith($haystack, $needle){

    if(is_string($haystack) == false) return false;
    if(!is_array($needle)) $needle = array($needle);

    foreach($needle as $n){
        $length = strlen($n);
        $start  = $length * -1; //negative
        if(strtolower(substr($haystack, $start)) === strtolower($n))
            return true;
    }

    return false;
}

function is_real_array(&$arr) {
    return (is_array($arr) && count(array_filter(array_keys($arr),'is_int')) == count($arr));
}

?>
