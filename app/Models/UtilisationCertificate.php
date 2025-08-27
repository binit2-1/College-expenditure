<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UtilisationCertificate extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public function expenditures(): BelongsToMany
    {
        return $this->belongsToMany(Expenditure::class, 'uc_expenditures', 'uc_id', 'expenditure_id');
    }
}
