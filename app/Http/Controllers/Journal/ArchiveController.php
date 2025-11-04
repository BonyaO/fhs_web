<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    /**
     * Display the archive/browse page with all volumes and issues
     */
    public function index(Request $request): View
    {
        $query = Volume::with(['issues' => function ($query) {
            $query->orderBy('number', 'desc')
                  ->with(['articles' => function ($q) {
                      $q->where('status', 'published')
                        ->with('authors')
                        ->orderBy('page_start');
                  }]);
        }]);

        // Apply filters
        if ($request->has('year')) {
            $query->whereYear('published_at', $request->year);
        }

        if ($request->has('keyword')) {
            $query->whereHas('issues.articles', function ($q) use ($request) {
                $q->where('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        $volumes = $query->orderBy('year', 'desc')->get();
        
        // Get available years for filter
        $availableYears = Volume::selectRaw('YEAR(published_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Archive'],
        ];

        return view('journal.archive', compact('volumes', 'availableYears', 'breadcrumbs'));
    }

    /**
     * Display a specific volume
     */
    public function volume(Request $request, $volume): View
    {
        $volumeModel = Volume::where('number', $volume)
            ->with(['issues' => function ($query) {
                $query->orderBy('number', 'desc')
                      ->with(['articles' => function ($q) {
                          $q->where('status', 'published')
                            ->with('authors')
                            ->orderBy('page_start');
                      }]);
            }])
            ->firstOrFail();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Archive', 'url' => route('journal.archive')],
            ['label' => "Volume {$volumeModel->number}"],
        ];

        return view('journal.volume', compact('volumeModel', 'breadcrumbs'));
    }

    /**
     * Display a specific issue
     */
    public function issue(Request $request, $volume, $issue): View
    {
        $issueModel = Issue::whereHas('volume', function ($query) use ($volume) {
            $query->where('number', $volume);
        })
            ->where('number', $issue)
            ->with([
                'volume',
                'articles' => function ($query) {
                    $query->where('status', 'published')
                          ->with('authors')
                          ->orderBy('page_start');
                }
            ])
            ->firstOrFail();

        // Get previous and next issues for navigation
        $previousIssue = Issue::with('volume')
            ->where('publication_date', '<', $issueModel->publication_date)
            ->orderBy('publication_date', 'desc')
            ->first();

        $nextIssue = Issue::with('volume')
            ->where('publication_date', '>', $issueModel->publication_date)
            ->orderBy('publication_date', 'asc')
            ->first();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Archive', 'url' => route('journal.archive')],
            ['label' => "Volume {$issueModel->volume->number}", 'url' => route('journal.archive.volume', $issueModel->volume->number)],
            ['label' => "Issue {$issueModel->number}"],
        ];

        return view('journal.issue', compact('issueModel', 'previousIssue', 'nextIssue', 'breadcrumbs'));
    }
}