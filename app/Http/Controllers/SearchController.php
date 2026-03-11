<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\MissingPersonRequest;
use App\Models\SearchQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('public.search');
    }

    public function store(SearchRequest $request): RedirectResponse
    {
        $query = $request->validated('query');

        $results = MissingPersonRequest::query()
            ->where('status', 'approved')
            ->where('full_name', 'like', '%' . $query . '%')
            ->latest()
            ->limit(20)
            ->get();

        SearchQuery::create([
            'user_id' => auth()->id(),
            'query_text' => $query,
            'results_count' => $results->count(),
        ]);

        return back()->with([
            'success' => __('site.search_completed', ['count' => $results->count()]),
            'search_results' => $results,
            'search_query' => $query,
        ]);
    }
}
