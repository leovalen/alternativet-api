<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $dates = [
        'valid_from',
        'valid_to',
        'renewed_at',
        'cancelled_at'
    ];

    public function __construct()
    {
        $this->setRawAttributes([
            'valid_from' => Carbon::now(),
            'valid_to' => Carbon::now()->addYear()
        ], true);

        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Scope a query to only include the currently active membership.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query
            ->where('valid_from', '<=', Carbon::now())
            ->where('valid_to', '>=', Carbon::now())
            ->whereNull('cancelled_at')
            ->orderBy('updated_at', 'desc')
            ->limit(1);
    }
}
