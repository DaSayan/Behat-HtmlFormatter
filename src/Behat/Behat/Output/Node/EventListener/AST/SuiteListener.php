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
use Behat\Behat\Output\Node\Printer\SuitePrinter;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteSetup;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
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
    /**
     * @var SuitePrinter
     */
    private $suitePrinter;


    /**
     * Initializes listener.
     *
     * @param SetupPrinter $setupPrinter
     * @param SuitePrinter $suitePrinter
     */
    public function __construct(
        SuitePrinter $suitePrinter,
        SetupPrinter $setupPrinter
    )
    {
        $this->setupPrinter = $setupPrinter;
        $this->suitePrinter = $suitePrinter;
    }

    /**
     * {@inheritdoc}
     */
    public function listenEvent(Formatter $formatter, Event $event, $eventName)
    {
        if ($event instanceof AfterSuiteSetup) {

            $this->setupPrinter->printSetup($formatter, $event->getSetup());
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

    }
}
