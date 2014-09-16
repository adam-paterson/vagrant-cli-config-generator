<?php
namespace VagrantConfig\Command\Vagrant;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Box command for setting and loading VirtualMachine configuration
 *
 * @package VagrantConfig\Command\Vagrant
 */
class Box extends Command
{
    /**
     * Configure Box command
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('box')
            ->addArgument('box', null, InputArgument::REQUIRED, 'Box name')
            ->setDescription('Set Vagrant box to use for Virtual Machine');
    }
}
