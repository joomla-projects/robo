<?php
/**
 * @package    Joomla-projects.Robo
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace joomla_projects\robo;

/**
 * Trait loadTasks
 * @package joomla_projects\robo
 */
trait loadTasks
{
	/**
	 * Task wait for Selenium Standalone Server
	 *
	 * @return WaitForSeleniumStandaloneServer
	 */
	protected function taskWaitForSeleniumStandaloneServer()
	{
		return $this->task(WaitForSeleniumStandaloneServer::class);
	}

	/**
	 * Task wait for Check code style
	 *
	 * @return CheckCodeStyle
	 */
	protected function taskCheckCodeStyle()
	{
		return new CheckCodeStyle;
	}
}
