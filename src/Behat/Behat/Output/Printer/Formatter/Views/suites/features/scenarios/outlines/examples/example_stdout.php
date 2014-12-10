<?php
 /********************************************************
 * @Filename:            example_stdout.php
 * @Last changed by:     walp
 * @Last changed date:   07/11/14 10:22 AM
 * @Created by:          PhpStorm
 ********************************************************/

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