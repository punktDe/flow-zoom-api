<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Command;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use DateTime;
use Neos\Flow\Cli\CommandController;
use PunktDe\Zoom\Api\Dto\Meeting;
use PunktDe\Zoom\Api\Dto\Registrant;
use PunktDe\Zoom\Api\Exception\ZoomApiException;
use PunktDe\Zoom\Api\Resource\MeetingResource;
use PunktDe\Zoom\Api\Resource\RegistrantResource;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerExceptionInterface;

class ZoomApiCommandController extends CommandController
{
    /**
     * @throws ZoomApiException
     * @throws SerializerExceptionInterface
     */
    public function testAddCommand(): void
    {
        $meetingsResource = new MeetingResource();

        $meeting = (new Meeting())
            ->setTopic('Testmeeting')
            ->setDuration(60)
            ->setStartTime((new DateTime())->modify('+1 day')->format('Y-m-d\TH:i:s\Z'))
            ->setHostEmail('zoom@punkt.de');
        $meeting = $meetingsResource->add($meeting, $meeting->getHostEmail());

        $registrant = (new Registrant())
            ->setEmail('info@acme.co')
            ->setFirstName('Vorname');
        $registrantResource = new RegistrantResource();
        $registrant = $registrantResource->add($registrant, $meeting->getIdentifier());
    }

    public function testDeleteCommand(): void
    {
        $meetingResource = new MeetingResource();
        $meetingCollection = $meetingResource->getAll([], 100, [], 'zoom@punkt.de');

        /** @var Meeting $meeting */
        foreach ($meetingCollection as $meeting) {
            $meetingResource->delete($meeting->getIdentifier());
        }
    }
}
