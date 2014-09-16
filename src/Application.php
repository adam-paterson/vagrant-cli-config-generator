<?php

namespace VagrantConfig;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use VagrantConfig\Application\ConfigLoader;

/**
 * Main application class.
 * @author Adam Paterson <hello@adampaterson.co.uk>
 * @package VagrantConfig
 */
class Application extends BaseApplication
{
    /**
     * Configuration loader
     * @var null
     */
    protected $configLoader = null;

    /**
     * Loaded configuration
     * @var
     */
    protected $config;

    /**
     * Partial configuration
     * @var
     */
    protected $partialConfig;

    /**
     * Set application name and version number
     */
    public function __construct()
    {
        parent::__construct('Vagrant Config Generator', '1.0.0');
    }

    /**
     * Run the application.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        if (null === $input) {
            $input = new ArgvInput();
        }

        if (null === $output) {
            $output = new ConsoleOutput();
        }

        try {
            $this->init([], $input, $output);
        } catch (\Exception $e) {
            $output = new ConsoleOutput();
            $this->renderException($e, $output);
        }

        $return = parent::run($input, $output);

        if ($return == null) {
            return 0;
        }

        return $return;
    }

    /**
     * Load default and user configuration
     *
     * @param array $initConfig
     * @param OutputInterface $output
     */
    public function init($initConfig = [], OutputInterface $output = null)
    {
        $configLoader = $this->getConfigLoader($initConfig, $output);
        $this->config = $configLoader->loadDistConfig($initConfig);
        $this->registerCustomCommands();
    }

    /**
     * Get configuration loader
     *
     * @param OutputInterface $output
     * @return null|ConfigLoader
     */
    public function getConfigLoader(OutputInterface $output)
    {
        if ($this->configLoader === null) {
            $this->configLoader = new ConfigLoader($this->config, $output);
        }

        return $this->configLoader;
    }

    /**
     * Get loaded config
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Register custom commands from config to for use in the application
     */
    protected function registerCustomCommands()
    {
        if (isset($this->config['commands']) && is_array($this->config['commands'])) {
            foreach ($this->config['commands'] as $commandClass) {
                $command = new $commandClass;
                $this->add($command);
            }
        }
    }
}
