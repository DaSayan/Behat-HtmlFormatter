<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer;

<<<<<<< HEAD
use Behat\Testwork\Output\Printer\OutputPrinter;
=======
use Behat\Behat\Output\Node\Printer\Helper\ResultToStringConverter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Symfony\Component\Translation\TranslatorInterface;
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95

/**
 * Behat counter printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
<<<<<<< HEAD
interface CounterPrinter
{
    /**
=======
final class CounterPrinter
{
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
     * @param ResultToStringConverter $resultConverter
     * @param TranslatorInterface     $translator
     */
    public function __construct(ResultToStringConverter $resultConverter, TranslatorInterface $translator)
    {
        $this->resultConverter = $resultConverter;
        $this->translator = $translator;
    }

    /**
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
     * Prints scenario and step counters.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param array         $stats
     */
<<<<<<< HEAD
    public function printCounters(OutputPrinter $printer, $intro, array $stats);

=======
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

            $detailedStats[] = sprintf('{+%s}%s{-%s}', $style, $message, $style);
        }

        $message = $this->translator->transChoice($intro, $totalCount, array('%1%' => $totalCount), 'output');
        $printer->write($message);

        if (count($detailedStats)) {
            $printer->write(sprintf(' (%s)', implode(', ', $detailedStats)));
        }

        $printer->writeln();
    }
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
}
