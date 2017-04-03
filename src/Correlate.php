<?php

namespace Ssipos\Correlate;

use Monolog\Logger;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;

class Correlate {
    /** @var string header name to add */
    private $correlationHeader = 'X-Correlation-ID';

    /** @var int UUID version */
    private $uuid = 4;

    /** @var \Monolog\Logger */
    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next) {
        $this->addCorrelationIdIfMissing($request);

        $this->addCorrelationIdToLoggerContext(
            $request->headers->get($this->correlationHeader)
        );

        return $next($request);
    }

    /**
     * @return \Webpatser\Uuid\Uuid
     */
    protected function uuid() {
        return Uuid::generate($this->uuid);
    }

    /**
     * @param string $correlationId
     */
    private function addCorrelationIdToLoggerContext($correlationId) {
        $this->logger->pushProcessor(function (array $record) use ($correlationId) {
            $record['context']['correlation-id'] = $correlationId;

            return $record;
        });
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function addCorrelationIdIfMissing(Request $request) {
        if (!$request->headers->has($this->correlationHeader)) {
            $request->headers->set($this->correlationHeader, (string) $this->uuid());
        }
    }
}

