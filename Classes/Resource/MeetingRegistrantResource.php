<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Resource;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

class MeetingRegistrantResource extends AbstractRegistrantResource
{
    protected function determineParentResourceName(): string
    {
        return 'meetings';
    }
}
