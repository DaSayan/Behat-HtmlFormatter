<?php
 /********************************************************
 * @Filename:            counter.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 1:10 PM
 * @Created by:          PhpStorm
 ********************************************************/
echo "<p class='{$intro}'>";
echo $view->render('counter_message.php', array('message' => $message));
echo $view->render('counter_detailedStats.php', array('detailedStats' => $detailedStats));
echo "</p>";

