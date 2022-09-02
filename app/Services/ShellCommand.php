<?php

namespace App\Services;

use Symfony\Component\Process\Process;

class ShellCommand
{

    public static function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
//            $exception = new ShellCommandFailedException($cmd . " - " . $processOutput);
//            report($processOutput);
            dump($processOutput);

//            throw 'error';
        }

        return $processOutput;
    }

    public static function batchChannel($channel) {

        return shell_exec("bash -c 'python3 /var/www/ParsingForTelegator_2/batch_channel.py ".$channel." batch_channel'");
    }

}
