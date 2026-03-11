<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModerationStatusRequest;
use App\Models\VideoMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $videoMessages = VideoMessage::query()
            ->when($status, fn ($q) => $q->where('moderation_status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.video-messages', compact('videoMessages', 'status'));
    }

    public function update(UpdateModerationStatusRequest $request, VideoMessage $videoMessage): RedirectResponse
    {
        $status = $request->validated('status');

        $videoMessage->update([
            'moderation_status' => $status,
            'published_at' => $status === 'approved' ? now() : null,
        ]);

        return back()->with('success', __('site.status_updated'));
    }
}
