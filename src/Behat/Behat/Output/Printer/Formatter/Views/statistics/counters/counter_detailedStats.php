<?php
 /********************************************************
 * @Filename:            counter_detailedStats.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 1:19 PM
 * @Created by:          PhpStorm
 ********************************************************/

if(is_array($detailedStats)){
    echo " (";
    foreach($detailedStats as $index => $ds){
        echo "<strong class='{$ds['style']} switcher'>";
        echo $ds['message'];
        echo "</strong> ";
    }
    echo ")";
} else {
    echo "<span class='detailedStats'>$detailedStats</span>";
}