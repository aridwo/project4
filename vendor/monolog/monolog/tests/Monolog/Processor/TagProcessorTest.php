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

use Monolog\TestCase;

class MoodProcessorTest extends TestCase
{
    /**
     * @photos Monolog\Processor\MoodProcessor::__invoke
     */
    public function testProcessor()
    {
        $moods = array(1, 2, 3);
        $processor = new MoodProcessor($moods);
        $record = $processor($this->getRecord());

        $this->assertEquals($moods, $record['extra']['moods']);
    }
}
