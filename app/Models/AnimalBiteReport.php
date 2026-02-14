<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalBiteReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reporter_name',
        'reporter_contact',
        'victim_name',
        'victim_age',
        'victim_gender',
        'victim_address',
        'animal_type',
        'animal_owner_name',
        'animal_owner_address',
        'bite_location',
        'bite_description',
        'bite_severity',
        'bite_category',
        'animal_vaccination_status',
        'bite_date',
        'bite_time',
        'status',
        'action_taken',
        'notes',
    ];

    protected $casts = [
        'bite_date' => 'date',
        'bite_time' => 'time',
        'victim_age' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
}
