<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use App\Models\Applicant;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $setting = AdmissionSetting::current();
        $acceptedCount = Applicant::query()
            ->where('selection_status', Applicant::SELECTION_ACCEPTED)
            ->count();

        return view('admin.dashboard', [
            'setting' => $setting,
            'totalApplicants' => Applicant::query()->count(),
            'pendingApplicants' => Applicant::query()
                ->where('verification_status', Applicant::VERIFICATION_PENDING)
                ->count(),
            'verifiedApplicants' => Applicant::query()
                ->where('verification_status', Applicant::VERIFICATION_VERIFIED)
                ->count(),
            'acceptedApplicants' => $acceptedCount,
            'reserveApplicants' => Applicant::query()
                ->where('selection_status', Applicant::SELECTION_RESERVE)
                ->count(),
            'remainingQuota' => max($setting->quota - $acceptedCount, 0),
            'latestApplicants' => Applicant::query()->latest()->take(5)->get(),
        ]);
    }
}
