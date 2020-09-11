<?php

namespace App;

use App\Model\Configuration\Stockpile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'stockpile_id', 'active', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Declare Accessor
     *
     * @var array
     */
    protected $appends = [
        'status', 'all_permissions', 'all_roles', 'stockpile_name'
    ];


    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get user status
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->active == 1) {
            $status = 'Active';
        } else {
            $status = 'Inactive';
        }
        return $status;
    }

    /**
     * Get User Permissions
     * @return array
     */
    public function getAllpermissionsAttribute()
    {
        $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach ($allPermissions as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

    /**
     * Get User Roles
     * @return array
     */
    public function getAllRolesAttribute()
    {
        $res = [];
        $roles = $this->roles;
        foreach ($roles as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

    public function stockpile()
    {
        return $this->belongsTo(Stockpile::class, 'stockpile_id', 'stockpile_id');
    }

    public function getStockpileNameAttribute()
    {
        return $this->stockpile->name;
    }

    public function getStockpileCodeAttribute()
    {
        return $this->stockpile->code;
    }
}
