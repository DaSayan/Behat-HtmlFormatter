<?php
 /********************************************************
 * @Filename:            feature_description.php
 * @Last changed by:     walp
 * @Last changed date:   04/11/14 1:00 PM
 * @Created by:          PhpStorm
 ********************************************************/


if (is_array($description)){
    echo "<span class='description'>";
    foreach ($description as $line) {
        echo $line . "</br>";
    }
    echo "</span>";
}
else {
    echo "<span class='description'>";
    echo $description;
    echo "</span>";
}

