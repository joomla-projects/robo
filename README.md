# robo

robo.li tasks for joomla

## Add Joomla Robo Tasks to you project:

Add this requirements to your composer.json:

```
    "require-dev": {
        "codegyre/robo": "^0.5.3",
        "joomla-projects/robo": "dev-master"
    }
```

Do:
`$ vendor/bin/robo init`

And make sure your RoboFile.php loads the Joomla Tasks:

```
<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
require 'vendor/autoload.php';

class RoboFile extends \Robo\Tasks
{
	// Load tasks from composer, see composer.json
	use \joomla_projects\robo\loadTasks;
``


## checkCodeStyle task

Use it like this in your RoboFile.php:

```
	private $extension = '';

	/**
	 * Set the Execute extension for Windows Operating System
	 *
	 * @return void
	 */
	private function setExecExtension()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			$this->extension = '.exe';
		}
	}

	/**
	 * Check the code style of the project against a passed sniffers using PHP_CodeSniffer_CLI
	 *
	 * @param   string  $sniffersPath  Path to the sniffers. If not provided Joomla Coding Standards will be used.
	 */
	public function checkCodestyle($sniffersPath = null)
	{
		if(is_null($sniffersPath))
		{
			$this->say('Downloading Joomla Coding Standards Sniffers');
			$this->_exec("git $this->extension clone -b master --single-branch --depth 1 https://github.com/joomla/coding-standards.git .travis/phpcs/Joomla");
			$sniffersPath = __DIR__ . '/.travis/phpcs/Joomla';
		}

		$this->taskCheckCodeStyle()
			->inspect(__DIR__ . '/component')
			->standard($sniffersPath)
			->ignore(__DIR__ . '/component/admin/views/*/tmpl/*')
			->ignore(__DIR__ . '/component/admin/views/*/tmpl/*')
			->ignore(__DIR__ . '/component/admin/views/*/tmpl/*')
			->ignore(__DIR__ . '*.js')
			->run()
			->stopOnFail();
	}
```

use `dontStopOnFail(true)` to always exit(0). Valid to avoid travis failing.