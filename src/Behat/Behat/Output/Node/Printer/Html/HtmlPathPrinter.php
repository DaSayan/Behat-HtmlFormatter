<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\Html;

use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Behat\Tester\Result\DefinedStepResult;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioLikeInterface as Scenario;
use Behat\Testwork\Output\Formatter;

/**
 * Prints paths for scenarios, examples, backgrounds and steps.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlPathPrinter
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;

    /**
     * Initializes printer.
     *
     * @param HtmlFormatter   $htmlFormatter
     * @param string          $basePath
     */
    public function __construct(
        HtmlFormatter $htmlFormatter,
        $basePath
    )
    {
        $this->basePath = $basePath;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * Prints scenario path comment.
     *
     * @param \Behat\Testwork\Output\Formatter $formatter
     * @param FeatureNode $feature
     * @param Scenario $scenario
     * @return Array
     */
    public function getScenarioPath(Formatter $formatter, FeatureNode $feature, Scenario $scenario)
    {
        if (!$formatter->getParameter('paths')) {
            return false;
        }

        $file = $this->relativizePaths($feature->getFile());
        $line = $scenario->getLine();

        return array($file, $line);
    }

    /**
     * Prints step path comment.
     *
     * @param Formatter  $formatter
     * @param StepResult $result
     * @return string
     */
    public function getStepPath(Formatter $formatter, StepResult $result) {

        if (!$result instanceof DefinedStepResult || !$result->getStepDefinition() || !$formatter->getParameter('paths')) {
            return false;
        }

        return $this->printDefinedStepPath($result);
    }

    /**
     * Prints defined step path.
     *
     * @param DefinedStepResult $result
     * @return string
     */
    private function printDefinedStepPath(DefinedStepResult $result)
    {
        $path = $result->getStepDefinition()->getPath();

        return $path;
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
