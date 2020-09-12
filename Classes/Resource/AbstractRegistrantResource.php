<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Resource;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use PunktDe\Zoom\Api\Dto\Registrant;

abstract class AbstractRegistrantResource extends AbstractResource
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
        return [
            'email' => true,
            'registrant_id' => true
        ];
    }

    protected function getDtoClass(): string
    {
        return Registrant::class;
    }
}
