<?php
 /********************************************************
 * @Filename:            suite_filters.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:51 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo "<h4>Filter Tags:</h4>";
if (is_array($filters)){
    echo "<ul class='list filters'>";
    foreach($filters as $filter){
        echo "<li>$filter</li>";
    }
    echo '</ul>';
}
else{
    echo "<span class='filters'>$filters</span>";
}
