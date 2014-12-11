<?php
 /********************************************************
 * @Filename:            feature_tags.php
 * @Last changed by:     walp
 * @Last changed date:   04/11/14 1:00 PM
 * @Created by:          PhpStorm
 ********************************************************/

if (is_array($tags)){
    echo '<ul class="tags">';
    foreach($tags as $tag){
        echo "<li class='{$tag}'>@$tag</li>";
    }
    echo '</ul>';
}
else{
    echo "<span class='tags'>$tags</span>";
}