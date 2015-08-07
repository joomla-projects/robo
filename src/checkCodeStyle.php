<?php
/**
 * @package    Joomla-projects.Robo
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */


namespace joomla_projects\robo;

use Robo\Result;
use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;
use Robo\Contract\CommandInterface;
use Robo\Contract\TaskInterface;
use Robo\Contract\PrintedInterface;
use Robo\Exception\TaskException;
use Robo\Common\Timer;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Process\Process;


/**
 * Class WaitForSeleniumStandaloneServerTask
 * @package joomla_projects\robo
 */
class checkCodeStyle extends BaseTask implements TaskInterface
{
    use Timer;

    public function ignore($path)
    {
        $this->ignored[] = $path;

        return $this;
    }


    public function inspect($path)
    {
        $this->files[] = $path;

        return $this;
    }

    public function standard($path = null)
    {
        $this->standard[] = $path;

        return $this;
    }

    /**
     * @return Result
     */
    public function run()
    {
        $this->startTimer();

        if (!isset($this->standard))
        {
            $this->standard[] = $this->getJoomlaCodingSniffers();
        }

        $this->printTaskInfo('Initialising CodeSniffer Checks...');

        // Build the options for the sniffer
        $options = array(
            'files' => $this->files,
            'standard' => $this->standard,
            'ignored' => $this->ignored,
            'showProgress' => true,
            'verbosity' => false
        );

        // Instantiate the sniffer
        $phpcs = new \PHP_CodeSniffer_CLI;

        // Ensure PHPCS can run, will exit if requirements aren't met
        $phpcs->checkRequirements();

        // Run the sniffs
        $numErrors = $phpcs->process($options);

        $this->stopTimer();

        if ($numErrors)
        {
            return \Robo\Result::error($this, "There were $numErrors issues detected.");
        }

        $this->say("There were no code style issues detected.");
        return new Result($this, 0, "There were no code style issues detected.", ['time' => $this->getExecutionTime()]);
    }
}
