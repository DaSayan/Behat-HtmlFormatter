<?php
 /********************************************************
 * @Filename:            list_stat.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 11:58 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo $view->render('list_stat_name.php', array('name' => $name));
echo $view->render('list_stat_path.php', array('path' => $path));
echo $view->render('list_stat_stdout.php', array('stdOut' => $stdOut));
echo $view->render('list_stat_exception.php', array('exception' => $exception));
