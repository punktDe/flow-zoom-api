<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Resource;

use PunktDe\Zoom\Api\Dto\Registrant;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

class RegistrantResource extends AbstractResource
{

    /**
     * @return string[]
     */
    protected function getPostFields(): array
    {
        return [
            'email' => true,
            'first_name' => true,
            'last_name' => false
        ];
    }

    /**
     * @return string[]
     */
    protected function getPatchFields(): array
    {
        return [];
    }

    protected function getDtoClass(): string
    {
        return Registrant::class;
    }

    protected function determineParentResourceName(): string
    {
        return 'meetings';
    }
}
