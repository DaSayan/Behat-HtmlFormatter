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
use Behat\Behat\Output\Node\Printer\Helper\StepTextPainter;
use Behat\Behat\Output\Node\Printer\StepPrinter;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Behat\Tester\Result\DefinedStepResult;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\ScenarioLikeInterface as Scenario;
use Behat\Gherkin\Node\StepNode;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\IntegerTestResult;
use Behat\Testwork\Tester\Result\TestResult;

/**
 * Prints steps as skipped.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlSkippedStepPrinter implements StepPrinter
{
    /**
     * @var StepTextPainter
     */
    private $textPainter;
    /**
     * @var ResultToStringConverter
     */
    private $resultConverter;
    /**
     * @var HtmlPathPrinter
     */
    private $pathPrinter;
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;

    /**
     * Initializes printer.
     *
     * @param HtmlFormatter           $htmlFormatter
     * @param StepTextPainter         $textPainter
     * @param ResultToStringConverter $resultConverter
     * @param HtmlPathPrinter         $pathPrinter
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        StepTextPainter $textPainter,
        ResultToStringConverter $resultConverter,
        HtmlPathPrinter $pathPrinter
    ) {
        $this->textPainter = $textPainter;
        $this->resultConverter = $resultConverter;
        $this->pathPrinter = $pathPrinter;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printStep(Formatter $formatter, Scenario $scenario, StepNode $step, StepResult $result)
    {
        $text = $this->getText($step->getText(), $result);
        $keyword = $step->getKeyword();
        $style = $this->resultConverter->convertResultToString($result);
        $path = $this->pathPrinter->getStepPath($formatter, $result);
        $argument = $this->getArguments($formatter, $step->getArguments(), $result);

        $templateValues = array(
            'text' => $text,
            'style' => $style,
            'keyword' => $keyword,
            'path' => $path,
            'argument' => $argument
        );

        $html = $this->htmlFormatter->getHtml('step.php', $templateValues);
        $formatter->getOutputPrinter()->write($html);

    }

    /**
     * Prints step text.
     *
     * @param string        $stepText
     * @param StepResult    $result
     * @return string
     */
    private function getText( $stepText, StepResult $result)
    {
        if ($result instanceof DefinedStepResult && $result->getStepDefinition()) {
            $definition = $result->getStepDefinition();
            $stepText = $this->textPainter->paintHtmlText(
                $stepText, $definition, new IntegerTestResult(TestResult::SKIPPED)
            );
        }

        return $stepText;
    }

    /**
     * Prints step multiline arguments.
     *
     * @param Formatter           $formatter
     * @param ArgumentInterface[] $arguments
     * @return string
     */
    private function getArguments(Formatter $formatter, array $arguments)
    {
        $text = '';
        foreach ($arguments as $argument) {
            $text .= $this->getArgumentString($argument, !$formatter->getParameter('multiline'));
        }
        return $text;
    }

    /**
     * Returns argument string for provided argument.
     *
     * @param ArgumentInterface $argument
     * @param Boolean           $collapse
     *
     * @return string
     */
    private function getArgumentString(ArgumentInterface $argument, $collapse = false)
    {
        if ($collapse) {
            return '...';
        }

        if ($argument instanceof PyStringNode) {
            $text = '"""' . "\n" . $argument . "\n" . '"""';

            return $text;
        }

        return (string) $argument;
    }
}
