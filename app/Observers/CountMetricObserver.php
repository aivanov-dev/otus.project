<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Prometheus\Gauge;

class CountMetricObserver
{

    /**
     * Handle the User "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        /**@var Gauge $gauge */
        $gauge = $model->getCountMetricGauge();
        $gauge->inc($model->getCountMetricLabelValues());
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model)
    {
        /**@var Gauge $gauge */
        $gauge = $model->getCountMetricGauge();
        $gauge->dec($model->getCountMetricLabelValues());
    }


}
