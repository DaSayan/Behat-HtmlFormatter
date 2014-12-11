<?php
 /********************************************************
 * @Filename:            list.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 11:00 AM
 * @Created by:          PhpStorm
 ********************************************************/

echo $view->render('list_intro.php', array('intro' => $intro, 'style' => $style));
echo "<ul class='list'>";
foreach($stats as $stat){
    echo "<li class='stat {$style}'>";
    if(is_array($stat)){
        echo $view->render('list_stat.php', array('name' => $stat['name'], 'path' => $stat['path'], 'stdOut' => $stat['stdOut'], 'exception' => $stat['exception']));
    }
    else{
        echo $stat;
    }
    echo "</li>";
}
echo "</ul>";
