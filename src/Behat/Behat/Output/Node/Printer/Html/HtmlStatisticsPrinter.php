<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\Html;

use Behat\Behat\Output\Node\Printer\Helper\ResultToStringConverter;
use Behat\Behat\Output\Node\Printer\StatisticsPrinter;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Behat\Output\Statistics\Statistics;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\TestResult;

/**
 * Prints exercise statistics.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlStatisticsPrinter implements StatisticsPrinter
{
    /**
     * @var HtmlCounterPrinter
     */
    private $counterPrinter;
    /**
     * @var HtmlListPrinter
     */
    private $listPrinter;

    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;
    /**
     * @var ResultToStringConverter
     */
    private $resultConverter;


    /**
     * Initializes printer.
     *
     * @param HtmlFormatter  $htmlFormatter
     * @param ResultToStringConverter $resultConverter
     * @param HtmlCounterPrinter $counterPrinter
     * @param HtmlListPrinter    $listPrinter
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        ResultToStringConverter $resultConverter,
        HtmlCounterPrinter $counterPrinter,
        HtmlListPrinter $listPrinter
    )
    {
        $this->htmlFormatter = $htmlFormatter;
        $this->resultConverter = $resultConverter;
        $this->counterPrinter = $counterPrinter;
        $this->listPrinter = $listPrinter;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printStatistics(Formatter $formatter, Statistics $statistics)
    {
        $printer = $formatter->getOutputPrinter();

        $skippedScenarioStats = $statistics->getSkippedScenarios();
        $failedScenarioStats = $statistics->getFailedScenarios();

        //If there are any failed or skipped scenarios than the summary is a fail
        $style = $this->resultConverter->convertResultCodeToString(TestResult::PASSED);
        if(count($failedScenarioStats) != 0 || count($skippedScenarioStats) != 0){
            $style = $this->resultConverter->convertResultCodeToString(TestResult::FAILED);
        }

        $html = $this->htmlFormatter->getHtml('statistics_header.php', array('style' => $style));
        $printer->write($html);

        $this->counterPrinter->printCounters($printer, 'scenarios_count', $statistics->getScenarioStatCounts());
        $this->counterPrinter->printCounters($printer, 'steps_count', $statistics->getStepStatCounts());

        if ($formatter->getParameter('timer')) {
            $timer = $statistics->getTimer();
            $memory = $statistics->getMemory();

            $this->counterPrinter->printTimer($printer, $timer);
            $this->counterPrinter->printMemory($printer, $memory);
        }

        $html = $this->htmlFormatter->getHtml('statistics_footer.php', array());
        $printer->write($html);

        $this->listPrinter->printScenariosList($printer, 'skipped_scenarios_title', TestResult::SKIPPED, $skippedScenarioStats);
        $this->listPrinter->printScenariosList($printer, 'failed_scenarios_title', TestResult::FAILED, $failedScenarioStats);

    }
}
