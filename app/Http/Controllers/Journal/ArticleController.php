<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a specific article
     */
    public function show(Article $article): View
    {
        // Eager load relationships
        $article->load(['authors', 'issue.volume', 'files']);
        
        // Get view and download counts
        $viewCount = ArticleView::where('article_id', $article->id)
            ->where('type', 'view')
            ->count();
        
        $downloadCount = ArticleView::where('article_id', $article->id)
            ->where('type', 'download')
            ->count();
        
        // Get related articles (same issue or similar keywords)
        $relatedArticles = Article::where('status', 'published')
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                // Same issue
                $query->where('issue_id', $article->issue_id)
                    // Or similar keywords
                    ->orWhere(function ($q) use ($article) {
                        if ($article->keywords) {
                            $keywords = explode(',', $article->keywords);
                            foreach ($keywords as $keyword) {
                                $q->orWhere('keywords', 'like', '%' . trim($keyword) . '%');
                            }
                        }
                    });
            })
            ->with('authors')
            ->limit(6)
            ->get();
        
        // Generate citation formats
        $citations = $this->generateCitations($article);
        
        // Build breadcrumbs
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Archive', 'url' => route('journal.archive')],
            ['label' => "Volume {$article->issue->volume->number}", 'url' => route('journal.archive.volume', $article->issue->volume->number)],
            ['label' => "Issue {$article->issue->number}", 'url' => route('journal.issue', [$article->issue->volume->number, $article->issue->number])],
            ['label' => $article->title],
        ];
        
        return view('journal.article', compact(
            'article', 
            'relatedArticles', 
            'citations', 
            'viewCount', 
            'downloadCount', 
            'breadcrumbs'
        ));
    }
    
    /**
     * Download article PDF
     */
    public function download(Article $article): Response
    {
        // Get the latest PDF file
        $file = $article->files()
            ->where('type', 'pdf')
            ->latest()
            ->first();
        
        if (!$file || !Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'PDF file not found');
        }
        
        // Track download
        ArticleView::create([
            'article_id' => $article->id,
            'type' => 'download',
            'ip_address' => request()->ip(),
        ]);
        
        // Generate filename
        $filename = $article->slug . '.pdf';
        
        return Storage::disk('public')->download($file->file_path, $filename);
    }
    
    /**
     * Track article view (AJAX endpoint)
     */
    public function trackView(Article $article)
    {
        ArticleView::create([
            'article_id' => $article->id,
            'type' => 'view',
            'ip_address' => request()->ip(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'View tracked successfully'
        ]);
    }
    
    /**
     * Search articles
     */
    public function search(Request $request): View
    {
        $query = Article::with(['authors', 'issue.volume'])
            ->where('status', 'published');
        
        // Search term
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('abstract', 'like', "%{$searchTerm}%")
                  ->orWhere('keywords', 'like', "%{$searchTerm}%")
                  ->orWhereHas('authors', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }
        
        // Year filter
        if ($request->filled('year')) {
            $query->whereHas('issue', function ($q) use ($request) {
                $q->whereYear('publication_date', $request->year);
            });
        }
        
        // Volume filter
        if ($request->filled('volume')) {
            $query->whereHas('issue.volume', function ($q) use ($request) {
                $q->where('number', $request->volume);
            });
        }
        
        // Issue filter
        if ($request->filled('issue')) {
            $query->whereHas('issue', function ($q) use ($request) {
                $q->where('number', $request->issue);
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'date');
        switch ($sortBy) {
            case 'relevance':
                // For relevance, we'll sort by exact matches first
                if ($request->filled('q')) {
                    $searchTerm = $request->q;
                    $query->orderByRaw("CASE 
                        WHEN title LIKE '%{$searchTerm}%' THEN 1 
                        WHEN abstract LIKE '%{$searchTerm}%' THEN 2 
                        WHEN keywords LIKE '%{$searchTerm}%' THEN 3 
                        ELSE 4 
                    END");
                }
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'date':
            default:
                $query->orderBy('publication_date', 'desc');
                break;
        }
        
        // Paginate results
        $articles = $query->paginate(10)->withQueryString();
        
        // Get filter options
        $availableYears = Article::select(\DB::raw('YEAR(publication_date) as year'))
            ->where('status', 'published')
            ->whereNotNull('publication_date')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Search Results'],
        ];
        
        return view('journal.search', compact('articles', 'availableYears', 'breadcrumbs'));
    }
    
    /**
     * Browse articles by author
     */
    public function byAuthor(Author $author): View
    {
        $articles = Article::whereHas('authors', function ($query) use ($author) {
            $query->where('authors.id', $author->id);
        })
            ->where('status', 'published')
            ->with(['authors', 'issue.volume'])
            ->orderBy('publication_date', 'desc')
            ->paginate(10);
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Authors'],
            ['label' => $author->name],
        ];
        
        return view('journal.author', compact('author', 'articles', 'breadcrumbs'));
    }
    
    /**
     * Browse articles by keyword
     */
    public function byKeyword(Request $request, string $keyword): View
    {
        $articles = Article::where('status', 'published')
            ->where('keywords', 'like', "%{$keyword}%")
            ->with(['authors', 'issue.volume'])
            ->orderBy('publication_date', 'desc')
            ->paginate(10);
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Keywords'],
            ['label' => ucfirst($keyword)],
        ];
        
        return view('journal.keyword', compact('keyword', 'articles', 'breadcrumbs'));
    }
    
    /**
     * Generate citation formats for an article
     */
    private function generateCitations(Article $article): array
    {
        $authorNames = $article->authors->pluck('name')->toArray();
        $year = $article->publication_date ? $article->publication_date->format('Y') : date('Y');
        $title = $article->title;
        $journal = 'African Annals of Health Sciences';
        $volume = $article->issue->volume->number;
        $issue = $article->issue->number;
        $pages = $article->page_start && $article->page_end 
            ? "{$article->page_start}-{$article->page_end}" 
            : '';
        
        // APA Format
        $apaAuthors = $this->formatAuthorsAPA($authorNames);
        $apa = "{$apaAuthors} ({$year}). {$title}. {$journal}, {$volume}({$issue})";
        if ($pages) {
            $apa .= ", {$pages}";
        }
        if ($article->doi) {
            $apa .= ". https://doi.org/{$article->doi}";
        }
        
        // MLA Format
        $mlaAuthors = $this->formatAuthorsMLA($authorNames);
        $mla = "{$mlaAuthors} \"{$title}.\" {$journal}, vol. {$volume}, no. {$issue}, {$year}";
        if ($pages) {
            $mla .= ", pp. {$pages}";
        }
        $mla .= ".";
        
        // Chicago Format
        $chicagoAuthors = $this->formatAuthorsChicago($authorNames);
        $chicago = "{$chicagoAuthors} \"{$title}.\" {$journal} {$volume}, no. {$issue} ({$year})";
        if ($pages) {
            $chicago .= ": {$pages}";
        }
        $chicago .= ".";
        
        // BibTeX Format
        $bibtexKey = $this->generateBibtexKey($authorNames[0] ?? 'Unknown', $year);
        $bibtex = "@article{{$bibtexKey},\n";
        $bibtex .= "  author = {" . implode(' and ', $authorNames) . "},\n";
        $bibtex .= "  title = {{$title}},\n";
        $bibtex .= "  journal = {{$journal}},\n";
        $bibtex .= "  volume = {{$volume}},\n";
        $bibtex .= "  number = {{$issue}},\n";
        if ($pages) {
            $bibtex .= "  pages = {{$pages}},\n";
        }
        $bibtex .= "  year = {{$year}},\n";
        if ($article->doi) {
            $bibtex .= "  doi = {{$article->doi}},\n";
        }
        $bibtex .= "}";
        
        return [
            'apa' => $apa,
            'mla' => $mla,
            'chicago' => $chicago,
            'bibtex' => $bibtex,
        ];
    }
    
    /**
     * Format authors for APA citation
     */
    private function formatAuthorsAPA(array $authors): string
    {
        if (empty($authors)) return 'Unknown';
        
        $formatted = [];
        foreach ($authors as $author) {
            $parts = explode(' ', trim($author));
            $lastName = array_pop($parts);
            $initials = implode('. ', array_map(fn($p) => strtoupper(substr($p, 0, 1)), $parts)) . '.';
            $formatted[] = "{$lastName}, {$initials}";
        }
        
        if (count($formatted) > 7) {
            return implode(', ', array_slice($formatted, 0, 6)) . ', ... ' . end($formatted);
        }
        
        if (count($formatted) > 1) {
            $last = array_pop($formatted);
            return implode(', ', $formatted) . ', & ' . $last;
        }
        
        return $formatted[0];
    }
    
    /**
     * Format authors for MLA citation
     */
    private function formatAuthorsMLA(array $authors): string
    {
        if (empty($authors)) return 'Unknown';
        
        $first = $authors[0];
        $parts = explode(' ', trim($first));
        $lastName = array_pop($parts);
        $firstName = implode(' ', $parts);
        
        if (count($authors) == 1) {
            return "{$lastName}, {$firstName}";
        } elseif (count($authors) == 2) {
            return "{$lastName}, {$firstName}, and {$authors[1]}";
        } else {
            return "{$lastName}, {$firstName}, et al";
        }
    }
    
    /**
     * Format authors for Chicago citation
     */
    private function formatAuthorsChicago(array $authors): string
    {
        if (empty($authors)) return 'Unknown';
        
        $formatted = [];
        foreach ($authors as $index => $author) {
            if ($index === 0) {
                $parts = explode(' ', trim($author));
                $lastName = array_pop($parts);
                $firstName = implode(' ', $parts);
                $formatted[] = "{$lastName}, {$firstName}";
            } else {
                $formatted[] = $author;
            }
        }
        
        if (count($formatted) > 3) {
            return $formatted[0] . ' et al';
        }
        
        if (count($formatted) > 1) {
            $last = array_pop($formatted);
            return implode(', ', $formatted) . ', and ' . $last;
        }
        
        return $formatted[0];
    }
    
    /**
     * Generate BibTeX citation key
     */
    private function generateBibtexKey(string $firstAuthor, string $year): string
    {
        $parts = explode(' ', trim($firstAuthor));
        $lastName = strtolower(array_pop($parts));
        return preg_replace('/[^a-z0-9]/', '', $lastName) . $year;
    }
}