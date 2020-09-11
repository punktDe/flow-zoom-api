# PunktDe.Zoom.Api

[![Latest Stable Version](https://poser.pugx.org/punktDe/flow-zoom-api/v/stable)](https://packagist.org/packages/punktDe/flow-zoom-api) [![Build Status](https://travis-ci.org/punktDe/zoom-api.svg?branch=master)](https://travis-ci.org/punktDe/zoom-api) [![Total Downloads](https://poser.pugx.org/punktDe/flow-zoom-api/downloads)](https://packagist.org/packages/punktDe/flow-zoom-api) [![License](https://poser.pugx.org/punktDe/flow-zoom-api/license)](https://packagist.org/packages/punktDe/flow-zoom-api)

This [Flow](https://flow.neos.io) package provides a programmable interface to the [Zoom API](https://marketplace.zoom.us/docs/api-reference/zoom-api/).

## Implemented Endpoints
The following Endpoints are currently implemented, see the [Admin API documentation](https://marketplace.zoom.us/docs/api-reference/zoom-api/) for details:

* Meeting
* Webinar
* Registrant

# Setup

## Installation

The installation is done with composer:

    composer require punktde/flow-zoom-api

## Configuration

* Create a set of JWT API-credentials
    * Log-in to your Zoom-Account and [create a new App](https://marketplace.zoom.us/develop/create)   
* Configure the required settings:
    * clientId
    * clientSecret
    * baseUri
    * zoomAccountIdentifier (your account's email-address) 

# Usage Examples

#### Find a single meeting by its identifier and host (user)
You need to provide an identifier for the host (user) of the meeting, since the api endpoint has no way of listing all meetings in an account

	/**
     * @Flow\Inject
     * @var PunktDe\Zoom\Api\Resource\MeetingResource
     */
    protected $meetings;

    /**
     * @param string $identifier
     * @param string $userIdentifier
     * @return PunktDe\Zoom\Api\Dto\Meeting
     */
    private function findOneMeetingByIdentifier(string $identifier, string $userIdentifier): PunktDe\Zoom\Api\Dto\Product {
        return $this->meetings->get($identifier, $userIdentifier);
    }
    
#### Add a registrant to an existing meeting

    /**
     * @Flow\Inject
     * @var PunktDe\Zoom\Api\Resource\MeetingRegistrantResource
     */
    protected $registrants;

    /**
     * @return Participant|null
     */
    private function addRegistrantToExistingMeeting(string $meetingIdentifier): ?PunktDe\Zoom\Api\Dto\Registrant
    {
        $registrant = (new Registrant())
            ->setEmail('info@acme.co')
            ->setFirstName('Pooh')
            ->setLastName('The Bear');
        return $this->registrants->add($registrant, $meetingIdentifier);
     }
