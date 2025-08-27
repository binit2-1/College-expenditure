<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Expenditure extends Model
{
    protected $fillable = [
        'item_name',
        'amount',
        'date',
        'category',
        'description',
        'receipt_path',
        'status',
        'submitted_by',
        'hod_approved_by',
        'hod_approved_at',
        'hod_notes',
        'admin_approved_by',
        'admin_approved_at',
        'admin_notes'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'hod_approved_at' => 'datetime',
        'admin_approved_at' => 'datetime'
    ];

    public function utilisationCertificates(): BelongsToMany
    {
        return $this->belongsToMany(UtilisationCertificate::class, 'uc_expenditures', 'expenditure_id', 'uc_id');
    }

    // Relationships for approval workflow
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function hodApprovedBy()
    {
        return $this->belongsTo(User::class, 'hod_approved_by');
    }

    public function adminApprovedBy()
    {
        return $this->belongsTo(User::class, 'admin_approved_by');
    }

    // Status methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isHoDApproved(): bool
    {
        return $this->status === 'hod_approved';
    }

    public function isHoDRejected(): bool
    {
        return $this->status === 'hod_rejected';
    }

    public function isAdminApproved(): bool
    {
        return $this->status === 'admin_approved';
    }

    public function isAdminRejected(): bool
    {
        return $this->status === 'admin_rejected';
    }

    public function isFinalApproved(): bool
    {
        return $this->status === 'final_approved';
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->submitted_by === $user->id && $this->isPending();
    }

    public function canBeApprovedByHoD(User $user): bool
    {
        return $user->canHoDApprove() && $this->isPending();
    }

    public function canBeApprovedByAdmin(User $user): bool
    {
        return $user->canApproveExpenses() && $this->isHoDApproved();
    }
}
