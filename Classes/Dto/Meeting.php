<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

class Meeting extends AbstractEvent implements ApiDtoInterface
{
    /**
     * Possible Options:
     * 1 => Instant Meeting
     * 2 => Scheduled Meeting (default)
     * 3 => Recurring Meeting with no fixed time
     * 8 => Recurring Meeting with fixed time
     * @var int
     */
    protected $type = 2;

    /**
     * @return mixed[]
     */
    protected function getDefaultSettings(): array
    {
        return [
            'approval_type' => 1,
            'registration_type' => 2,
            'use_pmi' => false
        ];
    }
}
