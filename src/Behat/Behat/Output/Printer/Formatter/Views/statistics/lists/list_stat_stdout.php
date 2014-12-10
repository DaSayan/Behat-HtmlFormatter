<?php
 /********************************************************
 * @Filename:            list_stat_stdout.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 12:50 PM
 * @Created by:          PhpStorm
 ********************************************************/

if($stdOut){
    if (is_array($stdOut)){
        echo '<ul class="stdOut">';
        foreach($stdOut as $out){
            echo "<li class='stdOut'>$out</li>";
        }
        echo '</ul>';
    }
    else{
        echo "<span class='stdOut'>$stdOut</span>";
    }
};