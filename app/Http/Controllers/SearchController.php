<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\MissingPersonRequest;
use App\Models\PersonInfoReport;
use App\Models\SearchQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        $section = request()->string('section')->toString();
        if (!in_array($section, ['missing', 'reports'], true)) {
            $section = 'missing';
        }

        return view('public.search', [
            'section' => $section,
            'latestMissingRequests' => MissingPersonRequest::query()
                ->where('status', 'approved')
                ->latest()
                ->limit(12)
                ->get(),
            'latestInfoReports' => PersonInfoReport::query()
                ->where('status', 'approved')
                ->latest()
                ->limit(12)
                ->get(),
        ]);
    }

    public function store(SearchRequest $request): RedirectResponse
    {
        $query = $request->validated('query');
        $section = $request->input('section') === 'reports' ? 'reports' : 'missing';

        if ($section === 'reports') {
            $results = PersonInfoReport::query()
                ->where('status', 'approved')
                ->where(function ($q) use ($query): void {
                    $q->where('target_person_name', 'like', '%' . $query . '%')
                        ->orWhere('message', 'like', '%' . $query . '%');
                })
                ->latest()
                ->limit(20)
                ->get();
        } else {
            $results = MissingPersonRequest::query()
                ->where('status', 'approved')
                ->where('full_name', 'like', '%' . $query . '%')
                ->latest()
                ->limit(20)
                ->get();
        }

        SearchQuery::create([
            'user_id' => auth()->id(),
            'query_text' => $query,
            'results_count' => $results->count(),
        ]);

        return back()->with([
            'success' => __('site.search_completed', ['count' => $results->count()]),
            'search_results' => $results,
            'search_query' => $query,
            'search_section' => $section,
        ]);
    }
}
