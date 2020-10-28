<?php

namespace Tests;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;
use Prometheus\RenderTextFormat;
use Aranyasen\LaravelPrometheusExporter\MetricsController;
use Aranyasen\LaravelPrometheusExporter\PrometheusExporter;

class MetricsControllerTest extends TestCase
{
    /** @test */
    public function classes_can_be_initialized(): void
    {
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $exporter = Mockery::mock(PrometheusExporter::class);
        $controller = new MetricsController($responseFactory, $exporter);
        self::assertSame($responseFactory, $controller->getResponseFactory());
        self::assertSame($exporter, $controller->getPrometheusExporter());
    }

    /** @test */
    public function getMetrics(): void
    {
        $response = Mockery::mock(Response::class);

        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('make')
            ->once()
            ->withArgs([
                "\n",
                200,
                ['Content-Type' => RenderTextFormat::MIME_TYPE],
            ])
            ->andReturn($response);

        $exporter = Mockery::mock(PrometheusExporter::class);
        $exporter->shouldReceive('export')
            ->once()
            ->andReturn([]);

        self::assertSame(
            $response,
            (new MetricsController($responseFactory, $exporter))->getMetrics()
        );
    }
}
