<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Resource;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use PunktDe\Zoom\Api\Dto\Meeting;

abstract class AbstractEventResource extends AbstractResource
{

    /**
     * Returns the fields that should be sent when creating
     * a new entity.
     *
     * format:
     *  ['fieldName' => required]
     *
     * @return bool[]
     */
    protected function getPostFields(): array
    {
        return [
            'topic' => true,
            'type' => true,
            'start_time' => false,
            'duration' => false,
            'timezone' => false,
            'password' => false,
            'agenda' => false,
            'settings' => true,
            'host_email' => true
        ];
    }


    /**
     * Returns the fields that should be sent when updating
     * an entity.
     *
     * format:
     *  ['fieldName' => required]
     *
     * @return bool[]
     */
    protected function getPatchFields(): array
    {
        return $this->getPostFields();
    }

    /**
     * @return string
     */
    protected function getDtoClass(): string
    {
        return Meeting::class;
    }

    protected function determineParentResourceName(): string
    {
        return 'users';
    }
}
