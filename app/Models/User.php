<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// 1. IMPORTAR ESTO PARA FILAMENT
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// 2. AGREGAR "implements FilamentUser"
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'email',
        'password',
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
        ];
    }

    // Una veterinario puede tener muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'veterinarian_id');
    }

    public function mascots(): HasMany
    {
        return $this->hasMany(Mascot::class, 'owner_id');
    }

    // 3. MÉTODO OBLIGATORIO PARA DAR ACCESO AL PANEL
    public function canAccessPanel(Panel $panel): bool
    {
        // Retornar true permite que cualquiera que inicie sesión entre al panel.
        // Esto es necesario para que tus Tests (actingAs) funcionen.
        // Más adelante puedes poner: return $this->hasRole('admin');
        return true;
    }
}
