<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CertificateSeries;
use App\Models\MeatInspectionReport;

class CertificateController extends Controller
{
    /**
     * Generate auto certificate number.
     */
    public function generateCertificateNumber(string $seriesName, string $prefix): string
    {
        return CertificateSeries::generateCertificateNumber($seriesName, $prefix);
    }

    /**
     * Generate meat inspection certificate.
     */
    public function generateMeatCertificate(MeatInspectionReport $report)
    {
        // Check if certificate already exists
        if ($report->certificate_no) {
            return $report->certificate_no;
        }

        // Generate certificate number
        $certificateNo = $this->generateCertificateNumber('MEAT_INSPECTION', 'MI');

        // Update the report
        $report->update([
            'certificate_no' => $certificateNo,
            'certificate_issued_by' => Auth::id(),
            'certificate_issued_at' => now(),
        ]);

        return $certificateNo;
    }

    /**
     * Generate rabies vaccination certificate.
     */
    public function generateRabiesCertificate($report)
    {
        if (isset($report->certificate_no) && $report->certificate_no) {
            return $report->certificate_no;
        }

        $certificateNo = $this->generateCertificateNumber('RABIES_VACCINATION', 'RAB');

        $report->update([
            'certificate_no' => $certificateNo,
            'issued_by' => Auth::id(),
            'issued_at' => now(),
        ]);

        return $certificateNo;
    }

    /**
     * Generate spay/neuter certificate.
     */
    public function generateSpayCertificate($report)
    {
        if (isset($report->certificate_no) && $report->certificate_no) {
            return $report->certificate_no;
        }

        $certificateNo = $this->generateCertificateNumber('SPAY_NEUTER', 'SN');

        $report->update([
            'certificate_no' => $certificateNo,
            'issued_by' => Auth::id(),
            'issued_at' => now(),
        ]);

        return $certificateNo;
    }

    /**
     * View certificate series (admin).
     */
    public function seriesIndex(Request $request)
    {
        $query = CertificateSeries::query();

        if ($request->has('year') && $request->year) {
            $query->where('year', $request->year);
        }

        $series = $query->orderBy('year', 'desc')->paginate(10);

        return view('certificates.series-index', compact('series'));
    }

    /**
     * Reset series number (admin only).
     */
    public function resetSeries(Request $request, CertificateSeries $series)
    {
        $request->validate([
            'last_number' => 'required|integer|min:0',
        ]);

        $series->update([
            'last_number' => $request->last_number,
        ]);

        return back()->with('success', 'Series number reset to ' . $request->last_number);
    }

    /**
     * Manual certificate number entry (admin override).
     */
    public function updateCertificateNumber(Request $request, $reportType, $reportId)
    {
        $request->validate([
            'certificate_no' => 'required|string|max:50|unique:'. $this->getTableName($reportType) .',certificate_no',
        ]);

        $model = $this->getModel($reportType);
        $report = $model::findOrFail($reportId);

        $report->update([
            'certificate_no' => $request->certificate_no,
        ]);

        return back()->with('success', 'Certificate number updated!');
    }

    /**
     * Helper to get table name based on report type.
     */
    private function getTableName(string $type): string
    {
        return match($type) {
            'meat' => 'meat_inspection_reports',
            'rabies' => 'rabies_vaccination_reports',
            'spay' => 'spay_neuter_reports',
            default => 'reports',
        };
    }

    /**
     * Helper to get model based on report type.
     */
    private function getModel(string $type)
    {
        return match($type) {
            'meat' => \App\Models\MeatInspectionReport::class,
            'rabies' => \App\Models\RabiesVaccinationReport::class,
            'spay' => \App\Models\SpayNeuterReport::class,
            default => \App\Models\Model::class,
        };
    }

    /**
     * API: Verify a certificate by series number.
     */
    public function verify(string $certificateSeries)
    {
        // First try exact match on series_name for better performance
        $certificate = CertificateSeries::where('series_name', $certificateSeries)->first();

        // If not found, try partial match (for flexible search)
        if (!$certificate) {
            $certificate = CertificateSeries::where('series_name', 'like', "%{$certificateSeries}%")
                ->first();
        }

        // If still not found, try to find by last_number (cast to integer for safety)
        if (!$certificate && is_numeric($certificateSeries)) {
            $certificate = CertificateSeries::where('last_number', (int) $certificateSeries)->first();
        }

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $certificate
        ]);
    }
}
