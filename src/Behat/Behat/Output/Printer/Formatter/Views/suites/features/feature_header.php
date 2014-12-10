<?php
 /********************************************************
 * @Filename:            feature_header.php
 * @Last changed by:     walp
 * @Last changed date:   04/11/14 2:29 PM
 * @Created by:          PhpStorm
 ********************************************************/
echo '<div class="feature">';
echo $view->render('feature_tags.php', array('tags' => $tags));
echo $view->render('feature_name.php', array('keyword' => $keyword, 'title' => $title));
if($description){echo $view->render('feature_description.php', array('description' => $description));};
