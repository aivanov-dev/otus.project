<?php


namespace App\Traits;


use App\Observers\CountMetricObserver;
use Prometheus\Gauge;
use Superbalist\LaravelPrometheusExporter\PrometheusFacade;

trait HasCountMetric
{
    public static function bootHasCountMetric()
    {
        static::observe(CountMetricObserver::class);
    }

    public function getCountMetricName(): string
    {
        return mb_strtolower(class_basename($this)) . '_count';
    }

    public function getCountMetricHelp(): string
    {
        return "Count of " . class_basename($this);
    }

    public function getCountMetricLabels(): array
    {
        return [
            'id'
        ];
    }

    public function getCountMetricLabelValues(): array
    {
        return [
            $this->getKey()
        ];
    }

    public function getCountMetricGauge(): Gauge{
        return PrometheusFacade::getFacadeRoot()->getOrRegisterGauge(
            $this->getCountMetricName(),
            $this->getCountMetricHelp(),
            $this->getCountMetricLabels()
        );
    }
}
