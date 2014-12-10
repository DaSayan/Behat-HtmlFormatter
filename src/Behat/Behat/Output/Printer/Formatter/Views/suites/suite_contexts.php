<?php
 /********************************************************
 * @Filename:            suite_contexts.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 12:30 PM
 * @Created by:          PhpStorm
 ********************************************************/
echo "<h4>Contexts:</h4>";
if (is_array($contexts)){
    echo "<ul class='list contexts'>";
    foreach($contexts as $context){
        echo "<ul>";
        foreach($context as $name => $params){
            echo "<strong>$name</strong>";
            foreach($params as $param => $value){
                if($param !='username' && $param != "password")
                echo "<li>$param : $value</li>";
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