<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonInfoReportRequest;
use App\Models\PersonInfoReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonInfoReportController extends Controller
{
    public function create(): View
    {
        return view('public.provide-info');
    }

    public function store(StorePersonInfoReportRequest $request): RedirectResponse
    {
        PersonInfoReport::create([
            ...$request->validated(),
            'reporter_user_id' => auth()->id(),
            'status' => 'new',
        ]);

        return back()->with('success', __('site.info_report_created'));
    }
}
