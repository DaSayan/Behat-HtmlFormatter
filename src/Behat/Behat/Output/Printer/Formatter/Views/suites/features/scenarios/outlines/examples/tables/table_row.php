<?php
 /********************************************************
 * @Filename:            table_row.php
 * @Last changed by:     walp
 * @Last changed date:   07/11/14 11:30 AM
 * @Created by:          PhpStorm
 ********************************************************/

echo "<tr>";
foreach($row as $col){
    echo $view->render('table_column.php', array('column' => $col));
};
echo "</tr>";

if($stdOut) { echo "<tr>"; echo $view->render('step_stdout.php', array('stdout' => $stdOut)); echo "</tr>";};
if($exception) { echo "<tr>"; echo $view->render('step_exception.php', array('exception' => $exception)); echo "</tr>";};
