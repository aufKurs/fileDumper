<?php

class FileDumper
{
    private const LINE   = "------------------------------------------------------------------------------------------------------------------------\n";
    private const FOLDER = './var/dump/';

    /**
     * @param mixed $var
     */
    public static function DUMP($var): void
    {
        // Define contents
        $calledFrom = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $headline1  = "{$calledFrom['file']} (Line: {$calledFrom['line']})"; // @phpstan-ignore-line
        $headline2  = "{$calledFrom['class']}::{$calledFrom['function']}()"; // @phpstan-ignore-line
        $dateTime   = (new \DateTime())->format('Y_m_d_\T_H_i_s.u');
        $filename   = "dump_{$dateTime}.txt";

        // Create folder if not exist
        if (!file_exists(self::FOLDER)) {
            mkdir(self::FOLDER, 0755, true);
        }

        // dump content in file
        ob_start();
        echo self::LINE;
        echo "File: {$headline1}\n";
        echo "Func: {$headline2}\n";
        echo "Date: {$dateTime}\n";
        echo self::LINE;
        var_dump($var);
        echo self::LINE;
        file_put_contents(self::FOLDER . $filename, ob_get_contents());
        ob_end_clean();
    }
}
