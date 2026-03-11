<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoMessageRequest;
use App\Models\VideoMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoMessageController extends Controller
{
    public function index(): View
    {
        return view('public.video-messages', [
            'videoMessages' => VideoMessage::query()->where('moderation_status', 'approved')->latest('published_at')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('public.video-messages-create');
    }

    public function store(StoreVideoMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $videoPath = $request->hasFile('video_file') ? $request->file('video_file')->store('video-messages', 'public') : null;
        $previewPath = $request->hasFile('preview_image') ? $request->file('preview_image')->store('video-previews', 'public') : null;

        VideoMessage::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'video_path' => $videoPath,
            'video_url' => $validated['video_url'] ?? null,
            'preview_image' => $previewPath,
            'moderation_status' => 'new',
        ]);

        return back()->with('success', __('site.video_created'));
    }
}
