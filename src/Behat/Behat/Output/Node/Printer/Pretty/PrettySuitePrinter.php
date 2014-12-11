<?php
 /********************************************************
 * @Filename:            PrettySuitePrinter.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:25 AM
 * @Created by:          PhpStorm
 ********************************************************/
namespace Behat\Behat\Output\Node\Printer\Pretty;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Suite\Suite;
use Behat\Behat\Output\Node\Printer\SuitePrinter;

class PrettySuitePrinter implements SuitePrinter {

    /**
     * Initializes printer.
     */
    public function __construct( ) {

    }

    public function printHeader(Formatter $formatter, Suite $suite){

    }

    public function printFooter(Formatter $formatter, Suite $suite){

    }


}