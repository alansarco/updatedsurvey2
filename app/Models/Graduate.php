<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'graduation_year',
        'phone_number',
        'gender',
        'facebook',
        'photo',
        'position',
        'company_name',
        'company_address',
        'industry_sector',
        'is_cpe_related',
        'has_awards',
        'is_involved_organizations',
        'employed',
        'lifelong_learner'
    ];

    protected $casts = [
        'employed' => 'integer',
        'graduation_year' => 'integer',
        'is_cpe_related' => 'boolean',
        'has_awards' => 'boolean',
        'is_involved_organizations' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
