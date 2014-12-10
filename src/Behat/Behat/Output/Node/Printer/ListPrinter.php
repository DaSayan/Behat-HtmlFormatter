<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer;
use Behat\Behat\Output\Statistics\HookStat;
use Behat\Behat\Output\Statistics\ScenarioStat;
use Behat\Behat\Output\Statistics\StepStat;
use Behat\Testwork\Output\Printer\OutputPrinter;


/**
 * Behat list printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface ListPrinter
{
    /**
     * Prints scenarios list.
     *
     * @param OutputPrinter  $printer
     * @param string         $intro
     * @param integer        $resultCode
     * @param ScenarioStat[] $scenarioStats
     */
    public function printScenariosList(OutputPrinter $printer, $intro, $resultCode, array $scenarioStats);


    /**
     * Prints step list.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param integer       $resultCode
     * @param StepStat[]    $stepStats
     */
    public function printStepList(OutputPrinter $printer, $intro, $resultCode, array $stepStats);


    /**
     * Prints failed hooks list.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param HookStat[]    $failedHookStats
     */
    public function printFailedHooksList(OutputPrinter $printer, $intro, array $failedHookStats);

}
