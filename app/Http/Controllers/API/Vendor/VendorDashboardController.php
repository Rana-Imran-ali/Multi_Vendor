<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Services\VendorDashboardService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly VendorDashboardService $dashboardService)
    {
    }

    /**
     * GET /api/vendor/dashboard
     * Returns full stats overview for the authenticated vendor.
     */
    public function index(Request $request)
    {
        $vendor = $request->user()->vendor;

        if (! $vendor || $vendor->status !== 'approved') {
            return $this->errorResponse('Your vendor account is not approved yet.', 403);
        }

        $stats = $this->dashboardService->getStats($vendor);

        return $this->successResponse($stats, 'Vendor dashboard loaded successfully.');
    }
}
