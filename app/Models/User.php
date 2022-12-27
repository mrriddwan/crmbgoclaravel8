<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

// use App\Models\Admin\Permission;

use App\Models\Admin\Announcement;
use App\Models\ToDo\ToDo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles, HasPermissions;
    use LaravelPermissionToVueJS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_password',
        'user_cat_id',
        'user_auth_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contact(){
        return $this -> hasOne(Contact::class);
    }

    public function forecast(){
        return $this->belongsTo(Forecast::class);
    }

    public function performance(){
        return $this -> hasMany(ToDo::class, 'user_id')->with('action');
    }

    public function billboard()
    {
        return $this->belongsTo(Billboard::class);
    }

    public function reminder()
    {
        return $this->hasMany(Announcement::class, 'to_user_id');
    }

    // public function announcement()
    // {
    //     return collect(Announcement::where('message_type_id', 1));
    // }
}
