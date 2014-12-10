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
use Behat\Behat\Output\Statistics\HookStat;
use Behat\Behat\Output\Statistics\ScenarioStat;
use Behat\Behat\Output\Statistics\StepStat;
use Behat\Testwork\Exception\ExceptionPresenter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Behat\Testwork\Tester\Result\TestResult;
use Symfony\Component\Translation\TranslatorInterface;
use Behat\Behat\Output\Node\Printer\ListPrinter;

/**
 * Behat list printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlListPrinter implements ListPrinter
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
     * @var ExceptionPresenter
     */
    private $exceptionPresenter;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var string
     */
    private $basePath;

    /**
     * Initializes printer.
     *
     * @param ResultToStringConverter $resultConverter
     * @param ExceptionPresenter      $exceptionPresenter
     * @param TranslatorInterface     $translator
     * @param HtmlFormatter           $htmlFormatter
     * @param string                  $basePath
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        ResultToStringConverter $resultConverter,
        ExceptionPresenter $exceptionPresenter,
        TranslatorInterface $translator,
        $basePath
    ) {
        $this->htmlFormatter = $htmlFormatter;
        $this->resultConverter = $resultConverter;
        $this->exceptionPresenter = $exceptionPresenter;
        $this->translator = $translator;
        $this->basePath = $basePath;
    }

    /**
     * Prints scenarios list.
     *
     * @param OutputPrinter  $printer
     * @param string         $intro
     * @param integer        $resultCode
     * @param ScenarioStat[] $scenarioStats
     */
    public function printScenariosList(OutputPrinter $printer, $intro, $resultCode, array $scenarioStats)
    {
        if (!count($scenarioStats)) {
            return;
        }

        $style = $this->resultConverter->convertResultCodeToString($resultCode);
        $intro = $this->translator->trans($intro, array(), 'output');

        $paths = array();
        foreach ($scenarioStats as $stat) {
            $paths[] = $this->relativizePaths((string) $stat);
        }

        $templateValues = array(
            'intro' => $intro,
            'stats' => $paths,
            'style' => $style
        );

        $html = $this->htmlFormatter->getHtml('list.php', $templateValues);
        $printer->write($html);
    }

    /**
     * Prints step list.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param integer       $resultCode
     * @param StepStat[]    $stepStats
     */
    public function printStepList(OutputPrinter $printer, $intro, $resultCode, array $stepStats)
    {
        if (!count($stepStats)) {
            return;
        }

        $style = $this->resultConverter->convertResultCodeToString($resultCode);
        $intro = $this->translator->trans($intro, array(), 'output');

        $stats = array();
        foreach ($stepStats as $stepStat) {
            $name = $stepStat->getText();
            $path = $stepStat->getPath();
            $stdOut = $stepStat->getStdOut();
            $error = $stepStat->getError();

            $stats[] = $this->getStat($name, $path, $stdOut, $error);
        }

        $templateValues = array(
            'intro' => $intro,
            'stats' => $stats,
            'style' => $style
        );

        $html = $this->htmlFormatter->getHtml('list.php', $templateValues);
        $printer->write($html);
    }

    /**
     * Prints failed hooks list.
     *
     * @param OutputPrinter $printer
     * @param string        $intro
     * @param HookStat[]    $failedHookStats
     */
    public function printFailedHooksList(OutputPrinter $printer, $intro, array $failedHookStats)
    {
        if (!count($failedHookStats)) {
            return;
        }

        $style = $this->resultConverter->convertResultCodeToString(TestResult::FAILED);
        $intro = $this->translator->trans($intro, array(), 'output');

        $hookedStats = array();
        foreach ($failedHookStats as $hookStat) {
            $name = $hookStat->getName();
            $path = $hookStat->getPath();
            $stdOut = $hookStat->getStdOut();
            $error = $hookStat->getError();

            $hookedStats[] = $this->getStat($name, $path, $stdOut, $error);
        }

        $templateValues = array(
            'intro' => $intro,
            'stats' => $hookedStats,
            'style' => $style
        );

        $html = $this->htmlFormatter->getHtml('list.php', $templateValues);
        $printer->write($html);
    }

    /**
     * Gets hook stat.
     *
     * @param string        $name
     * @param string        $path
     * @param null|string   $stdOut
     * @param null|string   $error
     * @return Array
     */
    private function getStat($name, $path, $stdOut, $error)
    {
        $path = $this->relativizePaths($path);

        $pad = function ($line) { return '      ' . $line; };

        $stdOutString = '';
        if (null !== $stdOut) {
            $padText = function ($line) { return '      │ ' . $line; };
            $stdOutString = array_map($padText, explode("\n", $stdOut));
        }
        $stdOut = $stdOutString || $stdOut;

        $exceptionString = '';
        if ($error) {
            $exceptionString = implode("\n", array_map($pad, explode("\n", $error)));
        }
        $error = $exceptionString || $error;

        return array('name' => $name, 'path' => $path, 'stdOut' => $stdOut, 'exception' => $error);
    }

    /**
     * Transforms path to relative.
     *
     * @param string $path
     *
     * @return string
     */
    private function relativizePaths($path)
    {
        if (!$this->basePath) {
            return $path;
        }

        return str_replace($this->basePath . DIRECTORY_SEPARATOR, '', $path);
    }
}
