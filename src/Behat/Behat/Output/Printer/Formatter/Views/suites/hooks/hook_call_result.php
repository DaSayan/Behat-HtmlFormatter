<?php
 /********************************************************
 * @Filename:            hook_call_result.php
 * @Last changed by:     walp
 * @Last changed date:   12/11/14 5:19 PM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<div class='hook call_result {$style}'>";
echo $view->render('hook_callee.php', array('hook' => $hook));
echo $view->render('hook_path.php', array('path' => $path));
if($stdOut) { echo $view->render('hook_stdout.php', array('stdout' => $stdOut));};
if($exception) { echo $view->render('hook_exception.php', array('exception' => $exception));};
echo "</div><!--end of hook call result-->";