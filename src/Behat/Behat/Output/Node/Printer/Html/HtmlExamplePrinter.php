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
use Behat\Behat\Output\Node\Printer\ExamplePrinter;
use Behat\Gherkin\Node\ExampleNode;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\TestResult;

/**
 * Prints example header (usually simply an example row) and footer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlExamplePrinter implements ExamplePrinter
{
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
     * @param HtmlFormatter     $htmlFormatter
     * @param HtmlPathPrinter   $pathPrinter
     */
    public function __construct(
        HTMLFormatter $htmlFormatter,
        HtmlPathPrinter $pathPrinter
    )
    {
        $this->pathPrinter = $pathPrinter;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printHeader(Formatter $formatter, FeatureNode $feature, ExampleNode $example)
    {
        $keyword = $example->getKeyword();
        $html = $this->htmlFormatter->getHtml('example_header.php', array('keyword' => $keyword));
        $formatter->getOutputPrinter()->write($html);

        $this->pathPrinter->getScenarioPath($formatter, $feature, $example);
    }

    /**
     * {@inheritdoc}
     */
    public function printFooter(Formatter $formatter, TestResult $result)
    {
        $html = $this->htmlFormatter->getHtml('example_footer.php', array());
        $formatter->getOutputPrinter()->write($html);
    }

}
