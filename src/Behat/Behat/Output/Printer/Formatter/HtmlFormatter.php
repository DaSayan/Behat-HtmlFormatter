<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Printer\Formatter;

use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\Helper\AssetsHelper;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * Symfony2 Console output formatter extended with custom highlighting tokens support.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class HtmlFormatter
{
    /**
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * @var PhpEngine
     */
    private $templating;


    /**
     * Initializes html formatter
     *
     */
    public function __construct( )
    {
        //Load the locations of the template files
        $this->loader = new FilesystemLoader(
            array(
                __DIR__.'/Views/statistics/%name%',
                __DIR__.'/Views/statistics/counters/%name%',
                __DIR__.'/Views/statistics/lists/%name%',
                __DIR__.'/Views/suites/%name%',
                __DIR__.'/Views/suites/hooks/%name%',
                __DIR__.'/Views/suites/features/%name%',
                __DIR__.'/Views/suites/features/scenarios/%name%',
                __DIR__.'/Views/suites/features/scenarios/outlines/%name%',
                __DIR__.'/Views/suites/features/scenarios/steps/%name%',
                __DIR__.'/Views/suites/features/scenarios/outlines/examples/%name%',
                __DIR__.'/Views/suites/features/scenarios/outlines/examples/tables/%name%',
            )
                                            );
        $this->templating = new PhpEngine(new TemplateNameParser(), $this->loader);
        $this->templating->set(new SlotsHelper());
        $this->templating->set(new AssetsHelper(__DIR__.'/Assets')); //Helps with css/js locations
    }
    /**
     * Renders a view given the template and array of values
     *
     * @param array $array The values for the view
     * @param string $template The name of the view to render
     *
     * @return string
     */
    public function getHtml($template, $array)
    {
        //Sanitize html if it's a string
        array_walk_recursive($array, function(&$value) {
                if(is_string($value)){
                    if (preg_match('!!u', $value)) {
                        //default encoding is ASCII, need to convert UTF-8 strings if any
                        $value = utf8_decode($value) ;
                    }
                    $value = htmlentities($value);
                };
            });
        
        return $this->templating->render($template, $array);
    }
}
