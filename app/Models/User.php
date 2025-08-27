<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role checking methods
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'principal', 'finance_officer']);
    }

    public function isHoD(): bool
    {
        return $this->role === 'department_head';
    }

    public function isFaculty(): bool
    {
        return $this->role === 'faculty';
    }

    public function canApproveExpenses(): bool
    {
        return in_array($this->role, ['admin', 'principal', 'finance_officer']);
    }

    public function canHoDApprove(): bool
    {
        return $this->role === 'department_head';
    }

    public function canCreateExpenses(): bool
    {
        return in_array($this->role, ['department_head', 'faculty']);
    }

    public function canGenerateUC(): bool
    {
        return in_array($this->role, ['admin', 'principal', 'finance_officer']);
    }

    // Relationships
    public function submittedExpenditures()
    {
        return $this->hasMany(Expenditure::class, 'submitted_by');
    }

    public function hodApprovedExpenditures()
    {
        return $this->hasMany(Expenditure::class, 'hod_approved_by');
    }

    public function adminApprovedExpenditures()
    {
        return $this->hasMany(Expenditure::class, 'admin_approved_by');
    }
}
