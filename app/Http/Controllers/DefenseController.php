<?php

namespace App\Http\Controllers;

use App\Models\Defense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DefenseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Defense::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%")
                  ->orWhere('jury_number', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('president_name', 'like', "%{$search}%")
                  ->orWhere('rapporteur_name', 'like', "%{$search}%")
                  ->orWhere('jury_members', 'like', "%{$search}%")
                  ->orWhere('thesis_title', 'like', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->get('date'));
        }

        // Filter by venue
        if ($request->filled('venue')) {
            $query->where('venue', $request->get('venue'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Get unique venues for filter dropdown
        $venues = Defense::distinct('venue')->pluck('venue')->sort();

        $defenses = $query->orderBy('date', 'desc')
                         ->orderBy('time', 'asc')
                         ->paginate(12);

        return view('defenses.index', compact('defenses', 'venues'));
    }

    public function show(Defense $defense): View
    {
        return view('defenses.show', compact('defense'));
    }
}