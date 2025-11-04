<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalController extends Controller
{
    /**
     * Display the journal homepage
     */
    public function home(): View
    {
        // Get latest issue
        $latestIssue = Volume::with(['issues' => function ($query) {
            $query->latest('publication_date')->with('articles.authors');
        }])
            ->latest('published_at')
            ->first()
            ?->issues
            ->first();

        // Get recent articles (last 8)
        $recentArticles = Article::with(['authors', 'issue.volume'])
            ->where('status', 'published')
            ->latest('publication_date')
            ->limit(8)
            ->get();

        // Get statistics
        $stats = [
            'total_volumes' => Volume::count(),
            'total_issues' => \App\Models\Issue::count(),
            'total_articles' => Article::where('status', 'published')->count(),
            'total_downloads' => \App\Models\ArticleView::where('type', 'download')->count(),
        ];

        return view('journal.home', compact('latestIssue', 'recentArticles', 'stats'));
    }

    /**
     * Display the about page
     */
    public function about(): View
    {
        $journalSettings = $this->getJournalSettings();
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'About'],
        ];

        return view('journal.about', compact('journalSettings', 'breadcrumbs'));
    }

    /**
     * Display submission guidelines
     */
    public function submission(): View
    {
        $journalSettings = $this->getJournalSettings();
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Submission Guidelines'],
        ];

        return view('journal.submission', compact('journalSettings', 'breadcrumbs'));
    }

    /**
     * Display policies page
     */
    public function policies(): View
    {
        $journalSettings = $this->getJournalSettings();
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Policies'],
        ];

        return view('journal.policies', compact('journalSettings', 'breadcrumbs'));
    }

    /**
     * Get journal settings (cached)
     * This will be replaced with actual settings from database
     */
    private function getJournalSettings(): object
    {
        // TODO: Replace with actual database query
        // For now, return default settings
        return (object) [
            'name' => 'African Annals of Health Sciences',
            'issn' => 'XXXX-XXXX', // To be updated
            'contact_email' => 'editor@africanannals.org',
            'description' => 'A peer-reviewed open access journal dedicated to advancing health sciences research in Africa.',
            'scope' => 'The African Annals of Health Sciences publishes original research, reviews, and case studies across all areas of health sciences relevant to Africa.',
            'frequency' => 'Quarterly',
            'open_access' => true,
            'license' => 'CC BY 4.0',
        ];
    }
}