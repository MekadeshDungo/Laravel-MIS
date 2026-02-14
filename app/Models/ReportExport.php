<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportExport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'report_exports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_type',
        'parameters',
        'file_path',
        'exported_by_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'exported_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who exported the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'exported_by_user_id');
    }
}
