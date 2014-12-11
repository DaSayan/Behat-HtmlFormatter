<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\Html;

use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Behat\Output\Node\Printer\ExampleRowPrinter;
use Behat\Behat\Output\Node\Printer\Helper\ResultToStringConverter;
use Behat\Behat\Tester\Result\ExecutedStepResult;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Gherkin\Node\ExampleNode;
use Behat\Gherkin\Node\OutlineNode;
use Behat\Testwork\EventDispatcher\Event\AfterTested;
use Behat\Testwork\Exception\ExceptionPresenter;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\ExceptionResult;
use Behat\Testwork\Tester\Result\TestResults;

/**
 * Prints example results in form of a table row.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlExampleRowPrinter implements ExampleRowPrinter
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
    public function printExampleRow(Formatter $formatter, OutlineNode $outline, ExampleNode $example, array $events)
    {
        $rowNum = array_search($example, $outline->getExamples()) + 1;
        $wrapper = $this->getWrapperClosure($outline, $example, $events);
        $row = $outline->getExampleTable()->getRowAsArrayWithWrappedValues($rowNum, $wrapper);
        list($exception, $stdOut) = $this->getStepExceptionsAndStdOut($events);

        $templateValues = array(
            'row' => $row,
            'stdOut' => $stdOut,
            'exception' => $exception
        );

        $row = $this->htmlFormatter->getHtml('table_row.php', $templateValues);
        $formatter->getOutputPrinter()->write($row);
    }

    /**
     * Creates wrapper-closure for the example table.
     *
     * @param OutlineNode   $outline
     * @param ExampleNode   $example
     * @param AfterStepTested[] $stepEvents
     *
     * @return callable
     */
    private function getWrapperClosure(OutlineNode $outline, ExampleNode $example, array $stepEvents)
    {
        $resultConverter = $this->resultConverter;

        return function ($value, $column) use ($outline, $example, $stepEvents, $resultConverter) {
            $results = array();
            foreach ($stepEvents as $event) {
                $index = array_search($event->getStep(), $example->getSteps());
                $header = $outline->getExampleTable()->getRow(0);
                $steps = $outline->getSteps();
                $outlineStepText = $steps[$index]->getText();

                if (false !== strpos($outlineStepText, '<' . $header[$column] . '>')) {
                    $results[] = $event->getTestResult();
                }
            }

            $result = new TestResults($results);
            $style = $resultConverter->convertResultToString($result);

            return array('value' => $value, 'style' => $style);
        };
    }

    /**
     * Get step events exceptions (if has some).
     *
     * @param AfterTested[] $events
     * @return String
     */
    private function getStepExceptionsAndStdOut(array $events)
    {
        $exception = '';
        $stdOut = '';
        foreach ($events as $event) {
            $stdOut .= $this->getStepStdOut($event->getTestResult());
            $exception .= $this->getStepException($event->getTestResult());
        }
        return array($exception, $stdOut);
    }

    /**
     * Gets step exception (if has one).
     *
     * @param StepResult    $result
     * @return String
     */
    private function getStepException(StepResult $result)
    {
        if (!$result instanceof ExceptionResult || !$result->hasException()) {
            return false;
        }

        $text = $this->exceptionPresenter->presentException($result->getException());
        return $text;
    }

    /**
     * Gets step output (if has one).
     *
     * @param StepResult    $result
     * @return Array
     */
    private function getStepStdOut(StepResult $result)
    {
        if (!$result instanceof ExecutedStepResult || null === $result->getCallResult()->getStdOut()) {
            return false;
        }

        return $result->getCallResult()->getStdOut();
    }
}
