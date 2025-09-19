<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Controllers;

use App\Applications\Admin\Actions\SellerDailySalesSummaryAction;
use App\Applications\Admin\Http\Requests\ResendCommissionSalleRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Seller\Models\Seller;
use Shared\Errors\HttpErrorStatus;

final class ResendCommissionEmailController
{
    public function __construct(private SellerDailySalesSummaryAction $action)
    {
    }

    public function __invoke(Seller $seller, ResendCommissionSalleRequest $request): JsonResponse
    {
        $this->action->handle(Carbon::parse($request->input('date')), $seller->getKey());

        return response()->json(status: HttpErrorStatus::NO_CONTENT->value);
    }
}
