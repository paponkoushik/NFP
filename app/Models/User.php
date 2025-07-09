<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasRole;
use App\Models\Traits\CreatedBy;
use App\Mail\PasswordResetEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Actions\Filters\QueryFilter;
use App\Enums\LegalReqTypes;
use App\Enums\UserRoles;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasUuids, HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRole, CreatedBy;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
        'ip_address',
        'invitation_token',
        'is_accept_terms',
        'is_online',
        'status',
        'last_login_at',
        'email_verified_at',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_online'         => 'boolean',
        'is_accept_terms'   => 'boolean',
        'last_login_at'     => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Email field name for resetting user password.
     *
     * @return string
     */
    // public function getEmailForPasswordReset()
    // {
    //     return $this->username;
    // }

    /**
     * Set password reset notify type.
     *
     * @return mixed
     */
    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
            case 'nexmo':
                return $this->phone_number;
        }
    }

    /**
     * Notify user to reset password.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new PasswordResetEmail($this, $token));
        // $this->notify(new PasswordReset($token));
    }

    /**
     * Get the organisation-user associated with the user.
     *
     */
    public function organisationUser()
    {
        return $this->hasOne(OrgUser::class);
    }


    public function userOrder()
    {
        return $this->hasOne(Order::class);
    }


    /**
     * The user has many organisations.
     */
    public function organisations()
    {
        return $this->belongsToMany(Organisation::class, 'org_users')
            ->withPivot(['is_primary',
                         'role',
                         'status']);
    }

    /**
     * Get the owner who owns the user.
     *
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    /**
     * Get the favourite documents of the user.
     *
     */
    public function favourites()
    {
        return $this->hasMany(SavedDocument::class)->ofFavourite();
    }

    /**
     * Get the following documents of the user.
     *
     */
    public function followings()
    {
        return $this->hasMany(SavedDocument::class)->ofFollowing();
    }

    /**
     * legal supports
     */
    public function legalSupports(): HasMany
    {
        return $this->hasMany(LegalRequest::class, 'requested_user_id');
    }

    /**
     * can legal support for lising or organisation
     *
     * @param string $type
     * @param string listingId | secondaryOrgId $id
     */
    public function canVisibleToLegalSupport(string $id, LegalReqTypes $type): bool
    {
        return $this->legalSupports()->when(
                $type === LegalReqTypes::Post,
                fn(Builder $query) => $query->where('listing_id', $id),
                fn(Builder $query) => $query->where('secondary_org_id', $id)
            )->count() === 0;
    }

    /**
     * Get user full name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Query Filter.
     *
     * @param QueryFilter $filters
     * @return Collection
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Scope a query to include users of a given organisation ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string/char $organisationId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrganisation($query, $organisationId = null)
    {

        if (empty($organisationId)) {
            return $query;
        } elseif ($organisationId == 'admin') {
            return $query->ofRole($organisationId);
        }

        return $query->whereHas('organisationUser', function ($q) use ($organisationId) {
            $q->ofOrganisation($organisationId);
        });
    }

    /**
     * Scope a query to include users of a given role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfRole($query, $role = null)
    {
        if (empty($role)) {
            return $query;
        } elseif (is_array($role)) {
            return $query->whereIn('role', $role);
        }

        return $query->whereRole($role);
    }

    /**
     * Scope a query to include users of a given status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, $status = 'active')
    {
        return $query->whereStatus($status);
    }

    /**
     * add query scope to get autocomplete users list
     *
     * @param $query
     * @param String $search
     * @param String $role
     * @return mix
     */
    public function scopeAutocompleteResult($query, $search, $role = 'lawyer')
    {
        return $query->select('id', 'first_name', 'last_name', 'email')
            ->whereRole($role)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', $search);
            })
            ->orderByAsc()
            ->limit(25)
            ->get();
    }

    /**
     * add query scope to order result set
     *
     * @param string $column
     * @return mix
     */
    public function scopeOrderByAsc($query, $column = 'first_name')
    {
        return $query->orderBy($column, 'asc');
    }

    /**
     * get legal admin emails
     */
    public static function legalAdminEmails(): array
    {
        $emails = self::whereRole(UserRoles::LegalAdmin)->pluck('email')->toArray();

        return [
            'to' => array_shift($emails),
            'cc' => $emails
        ];
    }

}
