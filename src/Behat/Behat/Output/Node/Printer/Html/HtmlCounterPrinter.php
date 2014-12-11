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
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Symfony\Component\Translation\TranslatorInterface;
use Behat\Behat\Output\Node\Printer\CounterPrinter;

/**
 * Behat counter printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlCounterPrinter implements CounterPrinter
{
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;

    /**
     * @var ResultToStringConverter
     */
    private $resultConverter;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Initializes printer.
     *
     * @param HtmlFormatter $htmlFormatter
     * @param ResultToStringConverter $resultConverter
     * @param TranslatorInterface     $translator
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        ResultToStringConverter $resultConverter,
        TranslatorInterface $translator
    )
    {
        $this->htmlFormatter = $htmlFormatter;
        $this->resultConverter = $resultConverter;
        $this->translator = $translator;
    }

    /**
     * Prints scenario and step counters.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param array         $stats
     */
    public function printCounters(OutputPrinter $printer, $intro, array $stats)
    {
        $stats = array_filter($stats, function ($count) { return 0 !== $count; });

        if (0 === count($stats)) {
            $totalCount = 0;
        } else {
            $totalCount = array_sum($stats);
        }

        $detailedStats = array();
        foreach ($stats as $resultCode => $count) {
            $style = $this->resultConverter->convertResultCodeToString($resultCode);

            $transId = $style . '_count';
            $message = $this->translator->transChoice($transId, $count, array('%1%' => $count), 'output');

            $detailedStats[] = array('message' => $message, 'style' => $style);
        }

        $message = $this->translator->transChoice($intro, $totalCount, array('%1%' => $totalCount), 'output');

        $tabIntro = explode('_', $intro) ;
        
        $templateValues = array(
            'intro' => $tabIntro[0],
            'detailedStats' => $detailedStats,
            'message' => $message
        );

        $html = $this->htmlFormatter->getHtml('counter.php', $templateValues);
        $printer->write($html);
    }

    public function printTimer(OutputPrinter $printer, $timer){
        $html = $this->htmlFormatter->getHtml('counter_timer.php', array('timer' => $timer));
        $printer->write($html);
    }

    public function printMemory(OutputPrinter $printer, $memory){
        $html = $this->htmlFormatter->getHtml('counter_memory.php', array('memory' => $memory));
        $printer->write($html);
    }
}
