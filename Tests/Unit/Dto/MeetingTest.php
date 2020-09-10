<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Tests\Unit\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use Exception;
use Neos\Flow\Tests\UnitTestCase;
use PunktDe\Zoom\Api\Dto\Meeting;

class MeetingTest extends UnitTestCase
{
    /**
     * @throws Exception
     * @test
     */
    public function startDateCanBeSetFromStringOrDateTime(): void
    {
        $dateString = '2020-01-01T00:00:00Z';
        $meeting = new Meeting();
        $meeting->setStartTime($dateString);

        $meetings2 = new Meeting();
        $meetings2->setStartTime((new \DateTime($dateString)));

        $this->assertEquals($meeting->getStartTime(), $meetings2->getStartTime());
    }

    /**
     * @test
     */
    public function identifierPropertyIsEqualToIdProperty(): void
    {
        $meeting = (new Meeting())->setId('123456789');
        $this->assertEquals($meeting->getIdentifier(), $meeting->getId());
    }
}
