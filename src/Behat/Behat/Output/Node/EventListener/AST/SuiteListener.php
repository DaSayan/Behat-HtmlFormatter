<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\EventListener\AST;

use Behat\Behat\Output\Node\Printer\SetupPrinter;
<<<<<<< HEAD
use Behat\Behat\Output\Node\Printer\SuitePrinter;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteSetup;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
=======
use Behat\Testwork\EventDispatcher\Event\AfterSuiteSetup;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested;
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Output\Node\EventListener\EventListener;
use Symfony\Component\EventDispatcher\Event;

/**
 * Behat suite listener.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
final class SuiteListener implements EventListener
{
    /**
     * @var SetupPrinter
     */
    private $setupPrinter;
<<<<<<< HEAD
    /**
     * @var SuitePrinter
     */
    private $suitePrinter;
=======
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95

    /**
     * Initializes listener.
     *
     * @param SetupPrinter $setupPrinter
<<<<<<< HEAD
     * @param SuitePrinter $suitePrinter
     */
    public function __construct(
        SuitePrinter $suitePrinter,
        SetupPrinter $setupPrinter
    )
    {
        $this->setupPrinter = $setupPrinter;
        $this->suitePrinter = $suitePrinter;
=======
     */
    public function __construct(SetupPrinter $setupPrinter)
    {
        $this->setupPrinter = $setupPrinter;
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
    }

    /**
     * {@inheritdoc}
     */
    public function listenEvent(Formatter $formatter, Event $event, $eventName)
    {
        if ($event instanceof AfterSuiteSetup) {
<<<<<<< HEAD
            $this->setupPrinter->printSetup($formatter, $event->getSetup(), $eventName);
            $this->suitePrinter->printHeader($formatter, $event->getSuite());

        }

        if ($event instanceof AfterSuiteTested) {
            $this->suitePrinter->printFooter($formatter, $event->getSuite());
            $this->setupPrinter->printTeardown($formatter, $event->getTeardown());
        }

        $this->printHeaderOnBeforeExercise($formatter, $eventName);
        $this->printFooterOnAfterExercise($formatter, $eventName);
    }

    /**
     * Prints header on exercise start event
     *
     * @param Formatter $formatter
     * @param string $eventName
     */
    private function printHeaderOnBeforeExercise($formatter, $eventName)
    {
        if (ExerciseCompleted::BEFORE !== $eventName) {
            return;
        }

        $this->suitePrinter->printExerciseHeader($formatter);
    }

    /**
     * Prints footer on exercise end event
     *
     * @param Formatter $formatter
     * @param string $eventName
     */
    private function printFooterOnAfterExercise($formatter, $eventName)
    {
        if (ExerciseCompleted::AFTER !== $eventName) {
            return;
        }

        $this->suitePrinter->printExerciseFooter($formatter);
=======
            $this->setupPrinter->printSetup($formatter, $event->getSetup());
        }

        if ($event instanceof AfterSuiteTested) {
            $this->setupPrinter->printTeardown($formatter, $event->getTeardown());
        }
>>>>>>> 33f400055af66ef1e24c0ca9404f7d14cf9a7c95
    }
}
