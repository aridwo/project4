<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Processor;

/**
 * Adds a moods array into record
 *
 * @author Martijn Riemers
 */
class MoodProcessor
{
    private $moods;

    public function __construct(array $moods = array())
    {
        $this->moods = $moods;
    }

    public function __invoke(array $record)
    {
        $record['extra']['moods'] = $this->moods;

        return $record;
    }
}
