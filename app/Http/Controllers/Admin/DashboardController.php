<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MissingPersonRequest;
use App\Models\PersonInfoReport;
use App\Models\SearchQuery;
use App\Models\VideoMessage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                __('site.missing_person_requests') => MissingPersonRequest::count(),
                __('site.person_info_reports') => PersonInfoReport::count(),
                __('site.video_messages') => VideoMessage::count(),
                __('site.search_queries') => SearchQuery::count(),
            ],
        ]);
    }
}
