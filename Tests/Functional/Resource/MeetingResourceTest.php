<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Tests\Functional\Resource;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Tests\FunctionalTestCase;
use PunktDe\Zoom\Api\Dto\Meeting;
use PunktDe\Zoom\Api\Dto\Registrant;
use PunktDe\Zoom\Api\Exception\ZoomApiConfigurationException;
use PunktDe\Zoom\Api\Exception\ZoomApiException;
use PunktDe\Zoom\Api\Resource\MeetingRegistrantResource;
use PunktDe\Zoom\Api\Resource\MeetingResource;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerExceptionInterface;

class MeetingResourceTest extends FunctionalTestCase
{

    /** @var MeetingResource */
    protected $meetingResource;

    /** @var MeetingRegistrantResource */
    protected $meetingRegistrantResource;

    /**
     * @var string
     * @Flow\InjectConfiguration(path='zoomAccountIdentifier')
     */
    protected $zoomAccountIdentifier;
    /**
     * Running the tests requires a zoom-api config
     * Since there is no sandbox available, credentials have to be manually set.
     * If no config is present, the tests will be skipped and marked as such.
     */
    protected function setUp(): void
    {
        parent::setup();
        try {
            $this->meetingResource = $this->objectManager->get(MeetingResource::class);
            $this->meetingRegistrantResource = $this->objectManager->get(MeetingRegistrantResource::class);
        } catch (ZoomApiConfigurationException $e) {
            $this->markTestSkipped('No zoom-api configuration present');
        }
    }

    /**
     * @test
     *
     * @throws ZoomApiException
     * @throws SerializerExceptionInterface
     */
    public function addMeetingAndRegistrant(): void
    {
        $meetingTopic = 'test';
        $meetingHostEmail = $this->zoomAccountIdentifier;
        $meeting = (new Meeting())
            ->setTopic($meetingTopic)
            ->setHostEmail($meetingHostEmail);

        // We need to automatically approve registrants to test
        $meeting->setSettings(array_merge($meeting->getSettings(), ['approval_type' => 0]));
        /** @var Meeting $meeting */
        $meeting = $this->meetingResource->add($meeting, $meeting->getHostEmail());

        $this->assertEquals($meeting->getTopic(), $meetingTopic);
        $this->assertEquals($meeting->getHostEmail(), $meetingHostEmail);

        $registrantEmail = 'info@acme.co';
        $registrantFirstName = 'Firstname';
        $registrant = (new Registrant())
            ->setEmail($registrantEmail)
            ->setFirstName($registrantFirstName);

        /** @var Registrant $registrant */
        $registrant = $this->meetingRegistrantResource->add($registrant, $meeting->getIdentifier());

        $registrants = $meeting->findRegistrants();

        $this->assertEquals(1, count($registrants));
        $this->assertEquals($registrant->getIdentifier(), $registrants[0]->getIdentifier());
    }

    /**
     * @test
     *
     * @throws SerializerExceptionInterface
     * @throws ZoomApiException
     */
    public function deleteMeeting(): void
    {
        $meetingTopic = 'test';
        $meetingHostEmail = 'zoom@punkt.de';
        $meeting = (new Meeting())
            ->setTopic($meetingTopic)
            ->setHostEmail($meetingHostEmail);

        /** @var Meeting $meeting */
        $meeting = $this->meetingResource->add($meeting, $meeting->getHostEmail());

        $this->assertTrue($this->meetingResource->delete($meeting->getIdentifier()));
    }

    /**
     * @test
     *
     * @throws SerializerExceptionInterface
     * @throws ZoomApiException
     */
    public function missingRequiredPropertyThrows(): void
    {
        $meeting = new Meeting();
        $this->expectException(ZoomApiException::class);

        $this->meetingResource->add($meeting);
    }
}
