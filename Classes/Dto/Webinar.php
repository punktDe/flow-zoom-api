<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

class Webinar extends AbstractEvent implements ApiDtoInterface
{
    /**
     * Possible Options:
     * 5 => Webinar (default)
     * 6 => Recurring webinar with no fixed time
     * 9 => Recurring Meeting with a fixed time
     * @var int
     */
    protected $type = 5;

    public function getRegistrantsRestrictNumber(): int
    {
        return (int)$this->settings['registrants_restrict_number'] ?? 0;
    }

    public function setRegistrantsRestrictNumber(int $registrants_restrict_number): Webinar
    {
        $this->settings['registrants_restrict_number'] = $registrants_restrict_number;
        return $this;
    }
}
