<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $summary = $this->dashboardService->getDashboardSummary();

        return view('admin-staff.dashboard.index', compact('summary'));
    }

    public function biteRabies()
    {
        $stats = $this->dashboardService->getBiteRabiesStats();
        $byCategory = $this->dashboardService->getBiteRabiesByCategory();
        $byAnimalType = $this->dashboardService->getBiteRabiesByAnimalType();
        $byAnimalStatus = $this->dashboardService->getBiteRabiesByAnimalStatus();
        $heatmap = $this->dashboardService->getBiteRabiesHeatmapData();
        $monthlyTrend = $this->dashboardService->getMonthlyBiteRabiesTrend();

        return view('admin-staff.dashboard.bite-rabies', compact(
            'stats',
            'byCategory',
            'byAnimalType',
            'byAnimalStatus',
            'heatmap',
            'monthlyTrend'
        ));
    }

    public function impounds()
    {
        $stats = $this->dashboardService->getImpoundStats();
        $heatmap = $this->dashboardService->getImpoundHeatmapData();

        return view('admin-staff.dashboard.impounds', compact('stats', 'heatmap'));
    }

    public function announcements()
    {
        $stats = $this->dashboardService->getAllAnnouncementsStats();
        $campaigns = $this->dashboardService->getRecentCampaigns(10);
        $events = $this->dashboardService->getUpcomingEvents(10);

        return view('admin-staff.dashboard.announcements', compact('stats', 'campaigns', 'events'));
    }

    public function heatmap()
    {
        $biteRabiesHeatmap = $this->dashboardService->getBiteRabiesHeatmapData();
        $impoundHeatmap = $this->dashboardService->getImpoundHeatmapData();
        $livestockData = $this->dashboardService->getLivestockCensusData();

        return view('admin-staff.dashboard.heatmap', compact(
            'biteRabiesHeatmap',
            'impoundHeatmap',
            'livestockData'
        ));
    }

    public function apiBiteRabiesStats()
    {
        return response()->json($this->dashboardService->getBiteRabiesStats());
    }

    public function apiBiteRabiesHeatmap()
    {
        return response()->json($this->dashboardService->getBiteRabiesHeatmapData());
    }

    public function apiImpoundHeatmap()
    {
        return response()->json($this->dashboardService->getImpoundHeatmapData());
    }

    public function apiAnnouncements()
    {
        return response()->json([
            'campaigns' => $this->dashboardService->getRecentCampaigns(),
            'events' => $this->dashboardService->getUpcomingEvents(),
        ]);
    }

    public function apiSummary()
    {
        return response()->json($this->dashboardService->getDashboardSummary());
    }
}