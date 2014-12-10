<?php
 /********************************************************
 * @Filename:            scenario_path.php
 * @Last changed by:     walp
 * @Last changed date:   05/11/14 3:04 PM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<span class='path'>";
echo $view->render('path_file.php', array('file' => $file));
echo $view->render('path_line.php', array('line' => $line));
echo "</span>";