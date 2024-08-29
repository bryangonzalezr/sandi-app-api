<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserSex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\HybridRelations;
use Spatie\Permission\Traits\HasRoles;
use MongoDB\Laravel\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens ,HybridRelations;

    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'sex',
        'birthdate',
        'age',
        'phone_number',
        'civil_status',
        'description',
        'objectives',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'sex' => UserSex::class,
        ];
    }

    protected function isNutritionist(): bool
    {
        return $this->hasRole('nutritionista');
    }

    protected function isPatient(): bool
    {
        return $this->hasRole('paciente');
    }

    protected function isBasicUser(): bool
    {
        return $this->hasRole('usuario_basico');
    }

    public function suscription()
    {
        return $this->belongsToMany(SuscriptionType::class, 'suscriptions', 'suscription_type_id', 'user_id');
    }

    public function nutritionalProfile()
    {
        return $this->hasOne(NutritionalProfile::class, 'patient_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'user_id');
    }

    public function dayMenus()
    {
        return $this->belongsToMany(DayMenu::class, 'user_day_menus', 'day_menu_id', 'user_id');
    }

    public function weekMenus()
    {
        return $this->belongsToMany(Menu::class, 'user_menus', 'menu_id', 'user_id')->where('timespan', 7);
    }

    public function monthMenus()
    {
        return $this->belongsToMany(Menu::class, 'user_menus', 'menu_id', 'user_id')->whereBetween('timespan', [28, 31]);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'nutritionist_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }

    public function progress()
    {
        return $this->hasOne(Progress::class);
    }
}
