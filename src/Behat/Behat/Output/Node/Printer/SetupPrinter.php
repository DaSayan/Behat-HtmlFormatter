<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer;

use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;

/**
 * Behat setup printer interface.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface SetupPrinter
{
    /**
     * Prints setup state.
     *
     * @param Formatter $formatter
     * @param Setup     $setup
<<<<<<< HEAD
<<<<<<< HEAD
     * @param string $eventName
     */
    public function printSetup(Formatter $formatter, Setup $setup, $eventName);
=======
     */
    public function printSetup(Formatter $formatter, Setup $setup);
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
=======
     */
    public function printSetup(Formatter $formatter, Setup $setup);
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95

    /**
     * Prints teardown state.
     *
     * @param Formatter $formatter
     * @param Teardown  $teardown
     */
    public function printTeardown(Formatter $formatter, Teardown $teardown);
}
