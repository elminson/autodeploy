<?php

use ptlis\ShellCommand\Command;
use ptlis\ShellCommand\CommandArgumentEscaped;
use ptlis\ShellCommand\CommandBuilder;
use ptlis\ShellCommand\Logger\NullProcessObserver;
use ptlis\ShellCommand\UnixEnvironment;

/**
 * Created by PhpStorm.
 * User: elminsondeoleo
 * Date: 2020-03-07
 * Time: 16:01
 */
class Setup
{

    public function __construct()
    {

    }

    /**
     *
     * @param $siteName
     * @return string
     */

    public function setupEnv($siteName)
    {

        $builder = new CommandBuilder();

        $command = $builder
            ->setCommand('pwd')
            ->buildCommand();
        $result = $command->runSynchronous();
        $path = $result->getStdOut();

        $path = preg_replace("/[^a-zA-Z\/]/", "", $path);
        $path .= '/src/commands.sh';

        $environment = new UnixEnvironment();
        $command = new Command(
            $environment,
            new NullProcessObserver(),
            $path,
            [
                new CommandArgumentEscaped($siteName, $environment)
            ],
            getcwd()
        );

        //$command->runSynchronous();
        $result = $command->runSynchronous();
        print_r($result);
        return $result->getStdOut();
        exit();

        $builder = new CommandBuilder();


        $command = $builder
            ->setCommand(trim($path . '/src/commands.sh'))
            ->addRawArgument($siteName)
            ->buildCommand();
        $result = $command->runSynchronous();
        return $result->getStdOut();
    }

    /**
     * @param $command
     * @param $param
     * @return string
     */
    private function execute($command, $param)
    {
        $builder = new CommandBuilder();
        $builder->setCommand($command);
        if (!empty($param)) {
            $builder->addArgument($param);
        }

        $command = $builder->buildCommand();
        $process = $command->runAsynchronous();
        return $process->getStdOut();
        $stdOut = $process->readStream(ProcessInterface::STDOUT);
        print_r($stdOut);


    }

}
