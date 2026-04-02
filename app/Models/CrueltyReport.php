<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrueltyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'reporter_name',
        'reporter_contact',
        'reporter_email',
        'accused_name',
        'accused_address',
        'location',
        'barangay_id',
        'incident_date',
        'animal_type',
        'animal_description',
        'animal_count',
        'violation_type',
        'description',
        'evidence_photos',
        'animal_photos',
        'witness_affidavit',
        'testify_in_court',
        'attend_hearings',
        'investigation_date',
        'investigator_id',
        'findings',
        'action_taken',
        'status',
        'outcome',
        'created_by',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'investigation_date' => 'date',
        'animal_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function investigator()
    {
        return $this->belongsTo(User::class, 'investigator_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public const VIOLATION_TYPES = [
        'neglect' => 'Neglect',
        'abuse' => 'Physical Abuse',
        'abandonment' => 'Abandonment',
        'illegal_confinement' => 'Illegal Confinement',
        'untreated_injury' => 'Untreated Injury',
        'starvation' => 'Starvation',
        'other' => 'Other',
    ];

    public const STATUSES = [
        'pending' => 'Pending',
        'investigating' => 'Investigating',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ];

    public const OUTCOMES = [
        'warning_issued' => 'Warning Issued',
        'citation_filed' => 'Citation Filed',
        'case_filed' => 'Case Filed',
        'animal_seized' => 'Animal Seized',
        'owner_counseled' => 'Owner Counseled',
        'no_violation' => 'No Violation Found',
    ];
}
