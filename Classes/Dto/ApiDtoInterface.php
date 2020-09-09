<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

interface ApiDtoInterface
{
    /**
     * Returns the unique identifier used for put operations
     * @return string
     */
    public function getIdentifier(): string;
}
