<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users', [
            'users' => User::query()->latest()->paginate(25),
        ]);
    }

    public function update(UpdateUserStatusRequest $request, User $user): RedirectResponse
    {
        if ($user->id === auth()->id() && $request->validated('status') === 'blocked') {
            return back()->with('error', __('site.self_block_forbidden'));
        }

        $user->update($request->validated());

        return back()->with('success', __('site.user_updated'));
    }
}
