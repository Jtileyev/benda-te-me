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
        $data = $request->validated();
        unset($data['image']);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('missing-person-requests', 'public')
            : null;

        MissingPersonRequest::create([
            ...$data,
            'applicant_user_id' => auth()->id(),
            'image_path' => $imagePath,
            'status' => 'new',
        ]);

        return back()->with('success', __('site.request_created'));
    }
}
