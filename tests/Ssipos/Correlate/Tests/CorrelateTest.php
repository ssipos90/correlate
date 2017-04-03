<?php

namespace Ssipos\Correlate\Tests;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Ssipos\Correlate\Correlate;

class CorrelateTest extends TestCase {
    /** @var \Ssipos\Correlate\Correlate */
    public $correlate;

    /** @var \Monolog\Logger */
    private $logger;

    /** @var \Monolog\Handler\TestHandler */
    private $loggerHandler;

    /** @before */
    public function createLogger() {
        $this->loggerHandler = new TestHandler();
        $this->logger = new Logger('correlation', [$this->loggerHandler]);
        $this->correlate = new Correlate($this->logger);
    }

    /** @test */
    public function going_through_correlate_middleware_attaches_processor_on_log() {
        // given
        $request = $this->makeLaravelRequest();
        $this->assertCount(0, $this->logger->getProcessors());

        // when
        $this->correlate->handle($request, $this->makeLambda());

        // then
        $this->assertCount(1, $this->logger->getProcessors());
    }

    /** @test */
    public function logging_a_message_appears_in_request_headers() {
        $request = $this->makeLaravelRequest();

        $this->correlate->handle($request, $this->makeLambda());

        $this->assertTrue($request->headers->has('X-Correlation-ID'));
    }

    /** @test */
    public function logging_a_message_appears_in_the_context() {
        $request = $this->makeLaravelRequest();

        $this->correlate->handle($request, function () {
            $this->logger->debug('viva-la-mexico');
        });
        $records = $this->loggerHandler->getRecords();
        $record = reset($records);

        $this->assertCount(1, $records);
        $this->assertArrayHasKey('correlation-id', $record['context']);
    }

    /**
     * @return \Closure
     */
    protected function makeLambda() {
        return function () {
            // no-op
        };
    }

    /**
     * @return \Illuminate\Http\Request
     */
    protected function makeLaravelRequest() {
        return new \Illuminate\Http\Request();
    }
}
