<?php
 /********************************************************
 * @Filename:            table_header.php
 * @Last changed by:     walp
 * @Last changed date:   07/11/14 11:25 AM
 * @Created by:          PhpStorm
 ********************************************************/
echo $view->render('outline_footer.php', array());
echo $view->render('example_header.php', array('keyword' => $keyword));
echo "<table class='table table-condensed table-bordered'>";
echo "<thead><tr>";
    foreach($row as $col){
        echo $view->render('table_header_column.php', array('column' => $col));
    }
echo "</tr></thead>";
echo "<tbody>";