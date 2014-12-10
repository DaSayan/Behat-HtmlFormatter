<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\Html;

use Behat\Behat\Output\Node\Printer\ScenarioPrinter;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioLikeInterface as Scenario;
use Behat\Gherkin\Node\TaggedNodeInterface;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;

/**
 * Prints scenario headers (with tags, keyword and long title) and footers.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlScenarioPrinter implements ScenarioPrinter
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
        HtmlFormatter $htmlFormatter,
        HtmlPathPrinter $pathPrinter
    )
    {
        $this->pathPrinter = $pathPrinter;
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printHeader(Formatter $formatter, FeatureNode $feature, Scenario $scenario)
    {
        if ($feature instanceof TaggedNodeInterface) {
            $tags = $scenario->getTags();
        }

        $title = $this->getTitle($scenario->getTitle());
        $keyword = $scenario->getKeyword();
        $description = $this->getDescription($scenario->getTitle());
        list($file, $line) = $this->pathPrinter->getScenarioPath($formatter, $feature, $scenario);

        $templateValues = array(
            'class' => strtolower($keyword),
            'title' => $title,
            'tags' => $tags,
            'keyword' => $keyword,
            'description' => $description,
            'file' => $file,
            'line' => $line
        );

        $html = $this->htmlFormatter->getHtml('scenario_header.php', $templateValues);
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * {@inheritdoc}
     */
    public function printFooter(Formatter $formatter, TestResult $result)
    {
        $html = $this->htmlFormatter->getHtml('scenario_footer.php', array());
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * Gets scenario title (first line of long title).
     *
     * @param string        $longTitle
     * @return string
     */
    private function getTitle($longTitle)
    {
        $description = explode("\n", $longTitle);
        $title = array_shift($description);

        //Returns first item
        return $title;
    }

    /**
     * Gets scenario description (other lines of long title).
     *
     * @param string        $longTitle
     * @return array
     */
    private function getDescription($longTitle)
    {
        $lines = explode("\n", $longTitle);

        //Returns all but first item
        return array_shift($lines);
    }
}
