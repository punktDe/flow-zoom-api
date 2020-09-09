<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use Neos\Flow\ResourceManagement\PersistentResource;

interface FileTransferringInterface
{
    /**
     * @return PersistentResource[]
     */
    public function getUploadResources(): array;
}
