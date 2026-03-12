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
        $data = $request->validated();
        unset($data['image']);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('person-info-reports', 'public')
            : null;

        PersonInfoReport::create([
            ...$data,
            'reporter_user_id' => auth()->id(),
            'image_path' => $imagePath,
            'status' => 'new',
        ]);

        return back()->with('success', __('site.info_report_created'));
    }
}
