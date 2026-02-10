<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Appointments\Schemas\AppointmentForm;
use App\Models\Appointment;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Guava\Calendar\Filament\Actions\CreateAction;
use Guava\Calendar\Filament\CalendarWidget as BaseCalendarWidget;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Support\Collection;

class CalendarWidget extends BaseCalendarWidget
{
    protected bool $eventClickEnabled = true;
    protected bool $dateClickEnabled = true;

    public static function canView(): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->can('ViewAllCalendarAppointments') 
            || $user->can('ViewOwnCalendarAppointments');
    }

    public function getHeading(): string
    {
        $user = auth()->user();
        
        if (!$user) {
            return 'Calendario de Citas';
        }
        
        if ($user->can('ViewAllCalendarAppointments')) {
            return 'Calendario de Citas (Todas)';
        }
        
        return 'Calendario de Mis Citas';
    }

    public function getEvents(FetchInfo $info): Collection
    {
        $user = auth()->user();
        
        if (!$user) {
            return collect();
        }
        
        $query = Appointment::with(['mascot', 'veterinarian'])
            ->whereDate('appointment_date', '>=', $info->start)
            ->whereDate('appointment_date', '<=', $info->end);

        // 🔑 FILTRADO SEGÚN PERMISOS
        if ($user->can('ViewAllCalendarAppointments')) {
            // ✅ Ver TODAS las citas (sin filtro)
        } elseif ($user->can('ViewOwnCalendarAppointments')) {
            // ✅ Ver SOLO SUS citas - FUNCIONA PARA TODOS LOS ROLES
            $query->where(function ($q) use ($user) {
                // 1. Citas donde es el veterinario
                $q->where('veterinarian_id', $user->id);
                
                // 2. O citas de SUS mascotas (si es dueño)
                $mascotIds = $user->mascots()->pluck('id');
                if ($mascotIds->isNotEmpty()) {
                    $q->orWhereIn('mascot_id', $mascotIds);
                }
            });
        } else {
            // ❌ Sin permisos
            return collect();
        }

        return $query->get()
            ->map(fn($appointment) => $appointment->toCalendarEvent());
    }

    protected function getDateClickContextMenuActions(): array
    {
        $user = auth()->user();
        
        if (!$user || !$user->can('CreateCalendarAppointments')) {
            return [];
        }

        return [
            CreateAction::make('createAppointment')
                ->model(Appointment::class)
                ->modalHeading('Nueva Cita')
                ->mountUsing(function ($arguments, $form) use ($user) {
                    $data = [
                        'appointment_date' => \Carbon\Carbon::parse(
                            data_get($arguments, 'data.dateStr', now())
                        )->setTime(9, 0),
                        'duration' => 30,
                        'status' => 'pending',
                    ];
                    
                    // 🔑 Auto-asignar según el rol del usuario
                    if ($user->can('ViewOwnCalendarAppointments') 
                        && !$user->can('ViewAllCalendarAppointments')) {
                        
                        // Si es veterinario, auto-asignarse
                        if ($user->hasRole('veterinario')) {
                            $data['veterinarian_id'] = $user->id;
                        }
                        
                        // Si es dueño y solo tiene UNA mascota, auto-seleccionarla
                        if ($user->hasRole('dueno_de_mascota') && $user->mascots()->count() === 1) {
                            $data['mascot_id'] = $user->mascots()->first()->id;
                        }
                    }
                    
                    $form->fill($data);
                })
                ->after(fn() => $this->refreshRecords()),
        ];
    }

    protected function getEventClickContextMenuActions(): array
    {
        $actions = [];
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }

        // View Action
        if ($user->can('ViewAllCalendarAppointments') 
            || $user->can('ViewOwnCalendarAppointments')) {
            $actions[] = $this->viewAction();
        }

        // Edit Action
        if ($user->can('EditCalendarAppointments')) {
            $actions[] = $this->editAction();
        }

        return $actions;
    }

    public function appointmentSchema(Schema $schema): Schema
    {
        return AppointmentForm::configure($schema);
    }

    public function viewAction(): \Guava\Calendar\Filament\Actions\ViewAction
    {
        return \Guava\Calendar\Filament\Actions\ViewAction::make()
            ->authorize(function ($record) {
                return $this->canViewAppointment($record);
            })
            ->extraModalFooterActions([
                Action::make('goToEdit')
                    ->label('Ir a la Cita')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn($record) => route('filament.admin.resources.appointments.edit', ['record' => $record]))
                    ->visible(fn($record) => $this->canEditAppointment($record))
                    ->close(),
            ]);
    }

    public function editAction(): \Guava\Calendar\Filament\Actions\EditAction
    {
        return \Guava\Calendar\Filament\Actions\EditAction::make()
            ->authorize(function ($record) {
                return $this->canEditAppointment($record);
            })
            ->after(fn() => $this->refreshRecords());
    }

    // 🔒 Verificar si puede VER una cita específica
    protected function canViewAppointment($record): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Si puede ver todas, autorizado
        if ($user->can('ViewAllCalendarAppointments')) {
            return true;
        }
        
        // Si puede ver solo las propias, verificar propiedad
        if ($user->can('ViewOwnCalendarAppointments')) {
            // Es su cita si:
            // 1. Es el veterinario asignado
            if ($record->veterinarian_id === $user->id) {
                return true;
            }
            
            // 2. O es una cita de SU mascota
            $mascotIds = $user->mascots()->pluck('id');
            if ($mascotIds->contains($record->mascot_id)) {
                return true;
            }
        }
        
        return false;
    }

    // 🔒 Verificar si puede EDITAR una cita específica
    protected function canEditAppointment($record): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Necesita el permiso de edición primero
        if (!$user->can('EditCalendarAppointments')) {
            return false;
        }
        
        // Si puede ver todas, puede editar todas
        if ($user->can('ViewAllCalendarAppointments')) {
            return true;
        }
        
        // Si solo ve las propias, solo puede editar las propias
        if ($user->can('ViewOwnCalendarAppointments')) {
            return $this->canViewAppointment($record);
        }
        
        return false;
    }
}