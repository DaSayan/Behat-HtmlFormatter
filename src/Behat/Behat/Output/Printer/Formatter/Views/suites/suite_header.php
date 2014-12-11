<?php
 /********************************************************
 * @Filename:            suite.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:47 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo '<div class="suite">';
echo $view->render('suite_name.php', array('name' => $name));
echo '<div class="suite_info">';
echo "<h3>Suite Settings</h3>";
echo $view->render('suite_filters.php', array('filters' => $filters));
echo $view->render('suite_contexts.php', array('contexts' => $contexts));
echo $view->render('suite_paths.php', array('paths' => $paths));
echo '</div><!--end the suite info div-->';
