<?php
 /********************************************************
 * @Filename:            HtmlSuitePrinter.php
 * @Last changed by:     walp
 * @Last changed date:   18/11/14 11:25 AM
 * @Created by:          PhpStorm
 ********************************************************/
namespace Behat\Behat\Output\Node\Printer\Html;
use Behat\Behat\Output\Printer\Formatter\HtmlFormatter;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Suite\Suite;
use Behat\Behat\Output\Node\Printer\SuitePrinter;

/**
 * Class HtmlSuitePrinter
 * @package Behat\Behat\Output\Node\Printer\Html
 */
class HtmlSuitePrinter implements SuitePrinter {
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;
    /**
     * Initializes printer.
     *
     * @param HtmlFormatter           $htmlFormatter
     */
    public function __construct(
        HtmlFormatter $htmlFormatter
    ) {
        $this->htmlFormatter = $htmlFormatter;
    }

    /**
     * @param Formatter $formatter
     * @param Suite $suite
     */
    public function printHeader(Formatter $formatter, Suite $suite){

        if (!$suite->hasSetting('filters') || !is_array($suite->getSetting('filters'))) {
            $filtersArray = array();
        } else {
            $filtersArray = $suite->getSetting('filters') ;
        }
    
        $templateValues = array(
            'name' => $suite->getName(),
            'filters' => $filtersArray,
            'contexts' => $suite->getSetting('contexts'),
            'paths' => $suite->getSetting('paths')
        );

        $html = $this->htmlFormatter->getHtml('suite_header.php', $templateValues);
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * @param Formatter $formatter
     * @param Suite $suite
     */
    public function printFooter(Formatter $formatter, Suite $suite){

        $html = $this->htmlFormatter->getHtml('suite_footer.php', array());
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * @param Formatter $formatter
     */
    public function printExerciseHeader(Formatter $formatter){

        $html = $this->htmlFormatter->getHtml('header.php', array());
        $formatter->getOutputPrinter()->write($html);
    }

    /**
     * @param Formatter $formatter
     */
    public function printExerciseFooter(Formatter $formatter){

        $html = $this->htmlFormatter->getHtml('footer.php', array());
        $formatter->getOutputPrinter()->write($html);
    }


}