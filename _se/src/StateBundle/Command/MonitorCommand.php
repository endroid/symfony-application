<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace StateBundle\Command;

use Endroid\State\Monitor;
use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonitorCommand extends Command
{
    //    use LockableTrait;

    /**
     * @var Monitor
     */
    private $monitor;

    /**
     * Creates a new instance.
     *
     * @param string  $name
     * @param Monitor $monitor
     */
    public function __construct($name, Monitor $monitor)
    {
        $this->monitor = $monitor;

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('state:monitor:run')
            ->setDescription('Runs the state monitor')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //        if (!$this->lock()) {
        //            $output->writeln('Aborting: command is already running');

        //            return 0;
        //        }

        $output->writeln('Running state monitor');
        $this->monitor->monitor(true);
    }
}
