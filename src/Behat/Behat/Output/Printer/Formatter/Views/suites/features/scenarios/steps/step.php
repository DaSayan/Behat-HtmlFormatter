<?php
 /********************************************************
 * @Filename:            step.php
 * @Last changed by:     walp
 * @Last changed date:   06/11/14 1:07 PM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<li class='{$style}'>";
echo "<div class='step'>";
echo $view->render('step_definition.php', array('text' => $text, 'keyword' => $keyword));
echo $view->render('step_path.php', array('path' => $path));
echo $view->render('step_argument.php', array('argument' => $args));
echo "</div><!--end of step-->";
if($stdOut) { echo $view->render('step_stdout.php', array('stdout' => $stdOut));};
if($exception) { echo $view->render('step_exception.php', array('exception' => $exception));};
echo "</li>";


