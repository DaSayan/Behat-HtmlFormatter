<?php
/********************************************************
 * @Filename:            feature_footer.php
 * @Last changed by:     walp
 * @Last changed date:   05/11/14 10:49 AM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<h2>";
echo $view->render('feature_keyword.php', array('keyword' => $keyword));
echo $view->render('feature_title.php', array('title' => $title));
echo "</h2>";