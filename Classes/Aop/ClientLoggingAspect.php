<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Aop;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Psr\Log\LoggerInterface;

/**
 * @Flow\Aspect
 */
class ClientLoggingAspect
{
    /**
     * @Flow\Inject
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param JoinPointInterface $joinPoint
     * @Flow\Around("method(PunktDe\Zoom\Api\Client->.*Async())")
     * @return mixed
     */
    public function logRequest(JoinPointInterface $joinPoint)
    {
        $timeStart = microtime(true);

        $result = $joinPoint->getAdviceChain()->proceed($joinPoint);

        $time = (int)((microtime(true) - $timeStart) * 1000);

        $this->logger->debug(sprintf('%s: %s | Time: %s ms', $joinPoint->getMethodName(), $joinPoint->getMethodArgument('url'), $time), [
            'FLOW_LOG_ENVIRONMENT' => [
                'packageKey' => 'PunktDe.Zoom.Api',
                'className' => __CLASS__,
                'methodName' => __FUNCTION__
            ]
        ]);

        return $result;
    }
}
