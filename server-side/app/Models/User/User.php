<?php

namespace App\Models\User;

use App\Filters\Base\BaseFilter;
use App\Filters\User\UserFilter;
use App\Helpers\AppHelper;
use App\Models\Base\ListingModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends ListingModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verify_code',
        'email_verified_at',
        'phone_dialing_number',
        'phone_number',
        'phone_verify_code',
        'phone_verified_at',
        'password',
        'status',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'phone_verify_code',
        'email_verify_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $appends = [
        'full_name',
        'verified',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's verified status.
     *
     * @return bool
     */
    public function getVerifiedAttribute(): bool
    {
        return $this->email_verified_at || $this->phone_verified_at;
    }

    /**
     * Check if the user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->roles()->count() > 0;
    }

    public function scopeListing($query): void
    {
        parent::scopeListing($query);
        $query->with(['roles:id,name']);
    }

    public function scopeFilter($query, BaseFilter $filter = null): void
    {
//        if ($filter) {
//            parent::scopeFilter($query, $filter);
//            $filter = $this->castObjectTo($filter, UserFilter::class);
//            if ($filter->isVerified()) {
//                $query->whereNotNull('email_verified_at')
//                    ->orWhereNotNull('phone_verified_at');
//            }
//        }
    }

    public function scopeList($query): void
    {
        // TODO: Implement scopeList() method.
    }
}
