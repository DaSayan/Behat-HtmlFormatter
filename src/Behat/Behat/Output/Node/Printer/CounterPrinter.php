<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer;

use Behat\Testwork\Output\Printer\OutputPrinter;

/**
 * Behat counter printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */

interface CounterPrinter
{
    /**
     * Prints scenario and step counters.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param array         $stats
     */
    public function printCounters(OutputPrinter $printer, $intro, array $stats);

}