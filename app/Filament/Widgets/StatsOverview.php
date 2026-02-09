<?php

namespace App\Filament\Widgets;

use App\Models\Mascot;
use App\Models\User;
use App\Models\Appointment; // Importamos el modelo de citas
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        // Lógica para obtener el crecimiento de citas en los últimos 7 días
        $appointmentsChart = Appointment::selectRaw('count(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupByRaw('date(created_at)')
            ->pluck('count')
            ->toArray();

        // Lógica para contar citas de HOY
        $citasHoy = Appointment::whereDate('appointment_date', Carbon::today())->count();

        return [
            // TARJETA 1: MASCOTAS
            Stat::make('Pacientes Registrados', Mascot::count())
                ->description('Mascotas en el sistema')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->chart([2, 4, 6, 8, 10, 12, 14]), // Simulación de crecimiento

            // TARJETA 2: DUEÑOS/USUARIOS
            Stat::make('Clientes Totales', User::count())
                ->description('Dueños de mascotas')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning')
                ->chart([10, 8, 12, 5, 15, 7, 20]),

            // TARJETA 3: CITAS REALES
            Stat::make('Citas para Hoy', $citasHoy)
                ->description($citasHoy > 0 ? 'Tienes trabajo hoy 🐾' : 'Día tranquilo')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($citasHoy > 0 ? 'info' : 'gray')
                ->chart(count($appointmentsChart) > 0 ? $appointmentsChart : [0, 0, 0, 0, 0, 0, 0]),
        ];
    }
}
