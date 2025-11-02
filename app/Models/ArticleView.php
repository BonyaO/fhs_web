<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Request;

class ArticleView extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'view_type',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the article that owns the view.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Create a new view record.
     */
    public static function record(Article $article, string $viewType = 'abstract_view'): void
    {
        static::create([
            'article_id' => $article->id,
            'view_type' => $viewType,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'referer' => Request::header('referer'),
            'country' => null, // You can integrate with a GeoIP service
            'created_at' => now(),
        ]);

        // Increment the appropriate counter on the article
        if ($viewType === 'abstract_view' || $viewType === 'full_view') {
            $article->incrementViews();
        } elseif ($viewType === 'pdf_download') {
            $article->incrementDownloads();
        }
    }

    /**
     * Scope a query to only include views of a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('view_type', $type);
    }

    /**
     * Scope a query to only include views from a date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include views from today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope a query to only include views from this week.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include views from this month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope a query to only include views from this year.
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', now()->year);
    }

    /**
     * Get view statistics for an article.
     */
    public static function getArticleStats(int $articleId): array
    {
        $views = static::where('article_id', $articleId);

        return [
            'total_views' => $views->ofType('abstract_view')->count() + 
                           $views->ofType('full_view')->count(),
            'abstract_views' => $views->ofType('abstract_view')->count(),
            'full_views' => $views->ofType('full_view')->count(),
            'downloads' => $views->ofType('pdf_download')->count(),
            'today' => $views->today()->count(),
            'this_week' => $views->thisWeek()->count(),
            'this_month' => $views->thisMonth()->count(),
            'this_year' => $views->thisYear()->count(),
        ];
    }

    /**
     * Get the most popular articles.
     */
    public static function getMostPopular(int $limit = 10, string $period = 'all')
    {
        $query = static::query();

        // Apply period filter
        switch ($period) {
            case 'today':
                $query->today();
                break;
            case 'week':
                $query->thisWeek();
                break;
            case 'month':
                $query->thisMonth();
                break;
            case 'year':
                $query->thisYear();
                break;
        }

        return $query->select('article_id')
            ->selectRaw('COUNT(*) as view_count')
            ->groupBy('article_id')
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->with('article')
            ->get()
            ->pluck('article');
    }

    /**
     * Anonymize old IP addresses for privacy compliance.
     */
    public static function anonymizeOldIps(int $daysOld = 90): void
    {
        static::where('created_at', '<', now()->subDays($daysOld))
            ->whereNotNull('ip_address')
            ->update(['ip_address' => null]);
    }
}