<?php
 /********************************************************
 * @Filename:            scenario_header.php
 * @Last changed by:     walp
 * @Last changed date:   05/11/14 11:35 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo "<div class='{$class}'>";
echo $view->render('scenario_tags.php', array('tags' => $tags));
echo $view->render('scenario_path.php', array('file' => $file, 'line' => $line));
echo $view->render('scenario_name.php', array('keyword' => $keyword, 'title' => $title));
//echo $view->render('scenario_description.php', array('description' => $description));
echo "<ol><!--start of scenario list-->";