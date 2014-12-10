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
use Behat\Behat\Output\Node\Printer\SetupPrinter;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Testwork\Call\CallResult;
use Behat\Testwork\Exception\ExceptionPresenter;
use Behat\Testwork\Hook\Tester\Setup\HookedSetup;
use Behat\Testwork\Hook\Tester\Setup\HookedTeardown;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;

/**
 * Prints hooks in a Html fashion.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlSetupPrinter implements SetupPrinter
{
    /**
     * @var ResultToStringConverter
     */
    private $resultConverter;
    /**
     * @var ExceptionPresenter
     */
    private $exceptionPresenter;
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;

    /**
     * Initializes printer.
     *
     * @param HtmlFormatter           $htmlFormatter
     * @param ResultToStringConverter $resultConverter
     * @param ExceptionPresenter      $exceptionPresenter
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        ResultToStringConverter $resultConverter,
        ExceptionPresenter $exceptionPresenter
    ) {
        $this->resultConverter = $resultConverter;
        $this->exceptionPresenter = $exceptionPresenter;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printSetup(Formatter $formatter, Setup $setup)    {

        if (!$setup instanceof HookedSetup) {
            return;
        }

        foreach ($setup->getHookCallResults() as $callResult) {
            $this->printSetupHookCallResult($formatter->getOutputPrinter(), $callResult);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function printTeardown(Formatter $formatter, Teardown $teardown)
    {
        if (!$teardown instanceof HookedTeardown) {
            return;
        }

        foreach ($teardown->getHookCallResults() as $callResult) {
            $this->printTeardownHookCallResult($formatter->getOutputPrinter(), $callResult);
        }
    }

    /**
     * Prints setup hook call result.
     *
     * @param OutputPrinter $printer
     * @param CallResult    $callResult
     */
    private function printSetupHookCallResult(OutputPrinter $printer, CallResult $callResult)
    {
        if (!$callResult->hasStdOut() && !$callResult->hasException()) {
            return;
        }

        $resultCode = $callResult->hasException() ? TestResult::FAILED : TestResult::PASSED;
        $style = $this->resultConverter->convertResultCodeToString($resultCode);
        $hook = $callResult->getCall()->getCallee();
        $path = $hook->getPath();
        $stdOut = $this->getHookCallStdOut($callResult);
        $exception = $this->getHookCallException($callResult);

        $templateValues = array(
            'style' => $style,
            'hook' => $hook,
            'path' => $path,
            'stdOut' => $stdOut,
            'exception' => $exception
        );

        $html = $this->htmlFormatter->getHtml('hook_call_result.php', $templateValues);
        $printer->write($html);
    }

    /**
     * Prints teardown hook call result.
     *
     * @param OutputPrinter $printer
     * @param CallResult    $callResult
     */
    private function printTeardownHookCallResult(OutputPrinter $printer, CallResult $callResult)
    {
        if (!$callResult->hasStdOut() && !$callResult->hasException()) {
            return;
        }

        $resultCode = $callResult->hasException() ? TestResult::FAILED : TestResult::PASSED;
        $style = $this->resultConverter->convertResultCodeToString($resultCode);
        $hook = $callResult->getCall()->getCallee();
        $path = $hook->getPath();
        $stdOut = $this->getHookCallStdOut($callResult);
        $exception = $this->getHookCallException($callResult);

        $templateValues = array(
            'style' => $style,
            'hook' => $hook,
            'path' => $path,
            'stdOut' => $stdOut,
            'exception' => $exception
        );

        $html = $this->htmlFormatter->getHtml('hook_call_result.php', $templateValues);
        $printer->write($html);
    }

    /**
     * Gets hook call output (if has some).
     *
     * @param CallResult    $callResult
     * @return string
     */
    private function getHookCallStdOut(CallResult $callResult)
    {
        if (!$callResult->hasStdOut()) {
            return false;
        }

        return $callResult->getStdOut();
    }

    /**
     * Gets hook call exception (if has some).
     *
     * @param CallResult    $callResult
     * @return string
     */
    private function getHookCallException(CallResult $callResult)
    {
        if (!$callResult->hasException()) {
            return false;
        }

        return $callResult->getException();
    }
}
