<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;

trait AuthorizesBusiness
{
    protected function authorizeBusiness(Model $model): void
    {
        if (!auth()->user()) {
            abort(403);
        }
        $businessId = $model->business_id;
        if (!$businessId || $businessId !== auth()->user()->business_id) {
            abort(403);
        }
    }
}
