<?php
 /********************************************************
 * @Filename:            SuitePrinter.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:25 AM
 * @Created by:          PhpStorm
 ********************************************************/
namespace Behat\Behat\Output\Node\Printer;


use Behat\Testwork\Suite\Suite;
use Behat\Testwork\Output\Formatter;

/**
 * Prints suite settings before suite
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface SuitePrinter
{
    /**
     * Prints suite header using provided formatter
     *
     * @param Formatter  $formatter
     * @param Suite $suite
     */
    public function printHeader(Formatter $formatter, Suite $suite);

    /**
     * Prints suite footer using provided formatter
     *
     * @param Formatter  $formatter
     * @param Suite $suite
     */
    public function printFooter(Formatter $formatter, Suite $suite);
}