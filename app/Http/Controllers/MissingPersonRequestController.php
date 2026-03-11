<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissingPersonRequest;
use App\Models\MissingPersonRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MissingPersonRequestController extends Controller
{
    public function create(): View
    {
        return view('public.missing-person');
    }

    public function store(StoreMissingPersonRequest $request): RedirectResponse
    {
        MissingPersonRequest::create([
            ...$request->validated(),
            'applicant_user_id' => auth()->id(),
            'status' => 'new',
        ]);

        return back()->with('success', __('site.request_created'));
    }
}
