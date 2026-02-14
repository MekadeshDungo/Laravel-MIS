<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_type',
        'title',
        'description',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created the form.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the announcements linked to this form.
     */
    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_forms', 'form_id', 'announcement_id')
            ->withTimestamps();
    }

    /**
     * Get the submissions for this form.
     */
    public function submissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }

    /**
     * Get pending submissions.
     */
    public function pendingSubmissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id')->where('status', 'pending');
    }

    /**
     * Get approved submissions.
     */
    public function approvedSubmissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id')->where('status', 'approved');
    }

    /**
     * Get form type label.
     */
    public function getTypeLabelAttribute()
    {
        return match($this->form_type) {
            'kapon' => 'Libre Kapon',
            'vaccination' => 'Vaccination',
            'pet_registration' => 'Pet Registration',
            'adoption' => 'Adoption',
            'bite_report' => 'Animal Bite Report',
            'stray_report' => 'Stray Animal Report',
            default => ucfirst(str_replace('_', ' ', $this->form_type)),
        };
    }
}
