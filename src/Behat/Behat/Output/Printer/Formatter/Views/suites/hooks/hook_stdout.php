<?php
 /********************************************************
 * @Filename:            hook_stdout.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 5:25 PM
 * @Created by:          PhpStorm
 ********************************************************/

if (is_array($stdOut)){
    echo '<ul class="stdOut">';
    foreach($stdOut as $out){
        echo "<li>$out</li>";
    }
    echo '</ul>';
}
else{
    echo "<span class='stdOut'>$stdOut</span>";
}