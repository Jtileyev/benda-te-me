<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModerationStatusRequest;
use App\Models\MissingPersonRequest;
use App\Models\PersonInfoReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $missing = MissingPersonRequest::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15, ['*'], 'missing_page');

        $reports = PersonInfoReport::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15, ['*'], 'reports_page');

        return view('admin.requests', compact('missing', 'reports', 'status'));
    }

    public function updateMissing(UpdateModerationStatusRequest $request, MissingPersonRequest $missingPersonRequest): RedirectResponse
    {
        $missingPersonRequest->update(['status' => $request->validated('status')]);

        return back()->with('success', __('site.status_updated'));
    }

    public function updateReport(UpdateModerationStatusRequest $request, PersonInfoReport $personInfoReport): RedirectResponse
    {
        $personInfoReport->update(['status' => $request->validated('status')]);

        return back()->with('success', __('site.status_updated'));
    }
}
