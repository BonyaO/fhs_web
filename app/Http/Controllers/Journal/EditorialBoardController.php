<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Models\EditorialBoard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EditorialBoardController extends Controller
{
    /**
     * Display the editorial board page
     */
    public function index(Request $request): View
    {
        // Get all board members
        $boardMembers = EditorialBoard::orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Group by role
        $groupedMembers = $boardMembers->groupBy('role');
        
        // Define role hierarchy for display order
        $roleHierarchy = [
            'Editor-in-Chief',
            'Deputy Editor-in-Chief',
            'Deputy Editor',
            'Managing Editor',
            'Associate Editor',
            'Section Editor',
            'Assistant Editor',
            'Editorial Board Member',
            'Advisory Board Member',
            'Editorial Assistant',
            'Statistical Editor',
            'Copy Editor',
        ];
        
        // Sort groups by role hierarchy
        $orderedMembers = collect();
        foreach ($roleHierarchy as $role) {
            if ($groupedMembers->has($role)) {
                $orderedMembers->put($role, $groupedMembers->get($role));
            }
        }
        
        // Add any roles not in hierarchy (just in case)
        foreach ($groupedMembers->keys() as $role) {
            if (!$orderedMembers->has($role)) {
                $orderedMembers->put($role, $groupedMembers->get($role));
            }
        }
        
        // Apply search filter if provided
        $searchQuery = $request->get('search');
        if ($searchQuery) {
            $orderedMembers = $orderedMembers->map(function ($members) use ($searchQuery) {
                return $members->filter(function ($member) use ($searchQuery) {
                    return stripos($member->name, $searchQuery) !== false ||
                           stripos($member->affiliation, $searchQuery) !== false ||
                           stripos($member->role, $searchQuery) !== false;
                });
            })->filter(function ($members) {
                return $members->isNotEmpty();
            });
        }
        
        // Get statistics
        $stats = [
            'total_members' => $boardMembers->count(),
            'roles_count' => $groupedMembers->count(),
            'countries' => $boardMembers->pluck('country')->filter()->unique()->count(),
        ];
        
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Editorial Board'],
        ];
        
        return view('journal.editorial-board', compact(
            'orderedMembers',
            'stats',
            'searchQuery',
            'breadcrumbs'
        ));
    }
    
    /**
     * Show individual board member profile (optional feature)
     */
    public function show(EditorialBoard $member): View
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('journal.home')],
            ['label' => 'Editorial Board', 'url' => route('journal.editorial-board')],
            ['label' => $member->name],
        ];
        
        // Get articles this board member has been involved with (if tracking this)
        // This would require additional database relationships
        $relatedArticles = collect(); // Placeholder
        
        return view('journal.board-member', compact('member', 'relatedArticles', 'breadcrumbs'));
    }
}