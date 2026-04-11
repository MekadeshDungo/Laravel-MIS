<?php

namespace App\Services;

use App\Models\BiteRabiesReport;
use App\Models\ImpoundRecord;
use App\Models\Announcement;
use App\Models\Livestock;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Barangay;
use Carbon\Carbon;

class DashboardService
{
    public function getBiteRabiesStats(): array
    {
        $total = BiteRabiesReport::count();

        return [
            'total' => $total,
        ];
    }

    public function getImpoundStats(): array
    {
        $total = ImpoundRecord::count();
        $approved = ImpoundRecord::approved()->count();
        $pending = ImpoundRecord::pending()->count();

        $byDisposition = [
            'impounded' => ImpoundRecord::where('current_disposition', 'impounded')->count(),
            'claimed' => ImpoundRecord::where('current_disposition', 'claimed')->count(),
            'adopted' => ImpoundRecord::where('current_disposition', 'adopted')->count(),
            'transferred' => ImpoundRecord::where('current_disposition', 'transferred')->count(),
            'euthanized' => ImpoundRecord::where('current_disposition', 'euthanized')->count(),
        ];

        return [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'by_disposition' => $byDisposition,
        ];
    }

    public function getGeneralStats(): array
    {
        return [
            'total_clients' => Client::count(),
            'active_clients' => Client::where('status', 'active')->count(),
            'total_pets' => Pet::count(),
            'total_livestock' => Livestock::count(),
            'total_barangays' => Barangay::count(),
        ];
    }

    public function getBiteRabiesHeatmapData(): array
    {
        return BiteRabiesReport::select('barangay_id', \DB::raw('COUNT(*) as total_cases'))
            ->whereNotNull('barangay_id')
            ->groupBy('barangay_id')
            ->with('barangay')
            ->get()
            ->map(function ($item) {
                return [
                    'barangay_id' => $item->barangay_id,
                    'barangay_name' => $item->barangay?->barangay_name ?? 'Unknown',
                    'latitude' => $item->barangay?->latitude,
                    'longitude' => $item->barangay?->longitude,
                    'total_cases' => (int) $item->total_cases,
                ];
            })
            ->toArray();
    }

    public function getImpoundHeatmapData(): array
    {
        return ImpoundRecord::approved()
            ->select('barangay_id', \DB::raw('COUNT(*) as total_cases'))
            ->whereNotNull('barangay_id')
            ->groupBy('barangay_id')
            ->with('barangay')
            ->get()
            ->map(function ($item) {
                return [
                    'barangay_id' => $item->barangay_id,
                    'barangay_name' => $item->barangay?->barangay_name ?? 'Unknown',
                    'latitude' => $item->barangay?->latitude,
                    'longitude' => $item->barangay?->longitude,
                    'total_cases' => (int) $item->total_cases,
                ];
            })
            ->toArray();
    }

    public function getLivestockCensusData(): array
    {
        return Livestock::select('barangay_id', 'species', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('barangay_id')
            ->groupBy('barangay_id', 'species')
            ->with('barangay')
            ->get()
            ->map(function ($item) {
                return [
                    'barangay_id' => $item->barangay_id,
                    'barangay_name' => $item->barangay?->barangay_name ?? 'Unknown',
                    'species' => $item->species,
                    'total' => (int) $item->total,
                ];
            })
            ->toArray();
    }

    public function getRecentCampaigns(int $limit = 5): array
    {
        return Announcement::where('category', 'campaign')
            ->published()
            ->orderBy('publish_date', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => $item->content,
                    'publish_date' => $item->publish_date,
                    'expiry_date' => $item->expiry_date,
                ];
            })
            ->toArray();
    }

    public function getUpcomingEvents(int $limit = 5): array
    {
        return Announcement::where('category', 'event')
            ->published()
            ->whereNotNull('event_date')
            ->where('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => $item->content,
                    'event_date' => $item->event_date,
                    'event_time' => $item->event_time,
                    'location' => $item->location,
                ];
            })
            ->toArray();
    }

    public function getAllAnnouncementsStats(): array
    {
        return [
            'total_campaigns' => Announcement::where('category', 'campaign')->count(),
            'published_campaigns' => Announcement::where('category', 'campaign')->where('status', 'published')->count(),
            'total_events' => Announcement::where('category', 'event')->count(),
            'upcoming_events' => Announcement::where('category', 'event')
                ->where('status', 'published')
                ->whereNotNull('event_date')
                ->where('event_date', '>=', Carbon::today())
                ->count(),
        ];
    }

    public function getBiteRabiesByCategory(): array
    {
        return BiteRabiesReport::select('category', \DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();
    }

    public function getBiteRabiesByAnimalType(): array
    {
        return BiteRabiesReport::select('animal_type', \DB::raw('COUNT(*) as total'))
            ->groupBy('animal_type')
            ->pluck('total', 'animal_type')
            ->toArray();
    }

    public function getBiteRabiesByAnimalStatus(): array
    {
        return BiteRabiesReport::select('animal_status', \DB::raw('COUNT(*) as total'))
            ->groupBy('animal_status')
            ->pluck('total', 'animal_status')
            ->toArray();
    }

    public function getMonthlyBiteRabiesTrend(int $months = 12): array
    {
        return BiteRabiesReport::select(
                \DB::raw('YEAR(incident_date) as year'),
                \DB::raw('MONTH(incident_date) as month'),
                \DB::raw('COUNT(*) as total')
            )
            ->where('incident_date', '>=', Carbon::now()->subMonths($months))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'total' => $item->total,
                ];
            })
            ->toArray();
    }

    public function getDashboardSummary(): array
    {
        return [
            'bite_rabies' => $this->getBiteRabiesStats(),
            'impounds' => $this->getImpoundStats(),
            'general' => $this->getGeneralStats(),
            'announcements' => $this->getAllAnnouncementsStats(),
            'heatmap' => [
                'bite_rabies' => $this->getBiteRabiesHeatmapData(),
                'impounds' => $this->getImpoundHeatmapData(),
            ],
            'recent_campaigns' => $this->getRecentCampaigns(),
            'upcoming_events' => $this->getUpcomingEvents(),
        ];
    }
}