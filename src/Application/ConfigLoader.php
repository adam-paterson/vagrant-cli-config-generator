<?php
namespace VagrantConfig\Application;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigLoader is used to loading repository distribution configs and user configs
 * @author Adam Paterson <hello@adampaterson.co.uk>
 */
class ConfigLoader
{
    /**
     * @var
     */
    protected $initialConfig;
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var
     */
    protected $distConfig;

    /**
     * @param $config
     * @param OutputInterface $output
     */
    public function __construct($config, OutputInterface $output)
    {
        $this->initialConfig = $config;
        $this->output = $output;
    }

    /**
     * @return array
     */
    public function loadDistConfig()
    {
        if ($this->distConfig == null) {
            $this->distConfig = Yaml::parse(__DIR__ . '/../../config.yaml');
        }

        if (OutputInterface::VERBOSITY_DEBUG <= $this->output->getVerbosity()) {
            $this->output->writeln('<debug>Load dist config</debug>');
        }
        $config = $this->distConfig;

        return $config;
    }
}