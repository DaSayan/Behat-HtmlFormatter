<?php
 /********************************************************
 * @Filename:            suite_contexts.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 12:30 PM
 * @Created by:          PhpStorm
 ********************************************************/
//list of excluded parameters
$excluded = array('username', 'login', 'password') ;

//function of strpos with an array of needles (stackoverflow)
function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}

echo "<h4>Contexts:</h4>";
if (is_array($contexts)){
    echo "<ul class='list contexts'>";
    foreach($contexts as $context){
        echo "<ul>";
        if (!is_array($context)) {
            continue ;
        }
        foreach($context as $name => $params){
            echo "<strong>$name</strong>";
            foreach($params as $param => $value){
                if (!is_array($value)) {
                    if(!strposa($param, $excluded)) {
                        echo "<li>$param : $value</li>";
                    }
                } else {
                    foreach($value as $param2 => $value2){
                        if(!strposa($param2, $excluded)) {
                            echo "<li>$param2 : $value2</li>";
                        }
                    }
                }
            }
           }
        echo "</ul>";
        echo "</li>";
    }
    echo '</ul>';
}
else{
    echo "<span class='contexts'>$contexts</span>";
}