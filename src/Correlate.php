<?php

namespace Ssipos\Correlate;

use Webpatser\Uuid\Uuid;

class Correlate {
    /** @var string header name to add */
    private $correlationHeader = 'X-Correlation-ID';

    /** @var int UUID version */
    private $uuid = 4;

    /** @var \Monolog\Logger */
    private $logger;

    public function __construct(\Monolog\Logger $logger) {
        $this->logger = $logger;
    }

    public function handle(\Illuminate\Http\Request $request, \Closure $next) {
        $this->addCorrelationIdIfMissing($request);

        $this->addCorrelationIdToLoggerContext(
            $request->headers->get($this->correlationHeader)
        );

        return $next($request);
    }

    protected function uuid(): Uuid {
        return Uuid::generate($this->uuid);
    }

    private function addCorrelationIdToLoggerContext($correlationId) {
        $this->logger->pushProcessor(function (array $record) use ($correlationId) {
            $record['context']['correlation-id'] = $correlationId;

            return $record;
        });
    }

    private function addCorrelationIdIfMissing(\Illuminate\Http\Request $request) {
        if (!$request->headers->has($this->correlationHeader)) {
            $request->headers->set($this->correlationHeader, (string) $this->uuid());
        }
    }
}

