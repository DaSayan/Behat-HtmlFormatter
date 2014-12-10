<?php
 /********************************************************
 * @Filename:            suite_list.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:51 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo "<h4>Paths:</h4>";
if (is_array($paths)){
    echo "<ul class='list paths'>";
    foreach($paths as $path){
        echo "<li>$path</li>";
    }
    echo '</ul>';
}
else{
    echo "<span class='paths'>$paths</span>";
}