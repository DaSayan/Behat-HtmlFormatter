<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\Html;

use Behat\Behat\Output\Node\Printer\FeaturePrinter;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\TaggedNodeInterface;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;


/**
 * Prints feature header and footer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class HtmlFeaturePrinter implements FeaturePrinter
{
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;

    /**
     * Initializes printer.
     *
     * @param HtmlFormatter  $htmlFormatter

     */
    public function __construct(
        HtmlFormatter $htmlFormatter
    )
    {
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function printHeader(Formatter $formatter, FeatureNode $feature)
    {
        if ($feature instanceof TaggedNodeInterface) {
            $tags = $feature->getTags();
        }

        $title = $feature->getTitle();
        $description = $this->getDescription($feature->getDescription());
        $keyword = $feature->getKeyword();

        $templateValues = array(
            'title' => $title,
            'tags' => $tags,
            'description' => $description,
            'keyword' => $keyword
        );

        $html = $this->htmlFormatter->getHtml('feature_header.php', $templateValues);
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * {@inheritdoc}
     */
    public function printFooter(Formatter $formatter, TestResult $result)
    {
        $html = $this->htmlFormatter->getHtml('feature_footer.php', array());
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * Gets feature description
     *
     * @param string        $description
     * @return array
     */
    private function getDescription($description)
    {
        return explode("\n", $description);
    }

}
