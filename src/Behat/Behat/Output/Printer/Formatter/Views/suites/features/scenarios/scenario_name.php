<?php
/********************************************************
 * @Filename:            feature_footer.php
 * @Last changed by:     walp
 * @Last changed date:   05/11/14 10:49 AM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<h3>";
echo $view->render('scenario_keyword.php', array('keyword' => $keyword));
echo $view->render('scenario_title.php', array('title' => $title));
echo "</h3>";