<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\CivilStatus;
use App\Enums\UserSex;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\HybridRelations;
use Spatie\Permission\Traits\HasRoles;
use MongoDB\Laravel\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens ,HybridRelations;

    protected $connection = 'pgsql';

    public $guard_name = 'web';

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
            'civil_status' => CivilStatus::class,
        ];
    }

    protected function isNutritionist(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->hasRole('nutricionista'),
        );
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

    public function nutritionalPlan()
    {
        return $this->hasOne(NutritionalPlan::class, 'patient_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'user_id');
    }

    public function dayMenus(): HasMany
    {
        return $this->hasMany(DayMenu::class, 'user_id');
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'user_id');
    }

    public function weekMenus(): HasMany
    {
        return $this->hasMany(Menu::class,'user_id')->where('timespan', 7);
    }

    public function monthMenus(): HasMany
    {
        return $this->hasMany(Menu::class,'user_id')->whereBetween('timespan', [28, 31]);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'nutritionist_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class, 'patient_id');
    }

    public function portions()
    {
        return $this->hasMany(Portion::class, 'patient_id');
    }

    public function servicePortion()
    {
        return $this->hasOne(ServicePortion::class, 'patient_id');
    }

    public function nutritionalRequirement()
    {
        return $this->hasOne(NutritionalRequirement::class, 'patient_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    public function contactCard()
    {
        return $this->hasOne(ContactCard::class, 'nutritionist_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'nutritionist_id');
    }
}
