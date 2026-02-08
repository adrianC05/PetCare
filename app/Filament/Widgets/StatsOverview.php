<?php

namespace App\Filament\Widgets;

use App\Models\Mascot;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Actualizar datos cada 15 segundos automáticamente
    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            // TARJETA 1: PACIENTES (Verde Esperanza)
            Stat::make('Pacientes Activos', Mascot::count())
                ->description('Total de mascotas registradas')
                ->descriptionIcon('heroicon-m-heart') // Corazón lleno
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Gráfico ascendente
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-all',
                ]),

            // TARJETA 2: DUEÑOS (Naranja Corporativo)
            Stat::make('Comunidad PetCare', User::count())
                ->description('Dueños confiando en nosotros')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->chart([3, 5, 3, 8, 2, 10, 6]),

            // TARJETA 3: CITAS (Azul Clínico)
            // Nota: Como aún no tenemos citas reales, dejamos '0' pero se ve bonito.
            Stat::make('Citas Programadas', '0')
                ->description('Agenda del día de hoy')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info')
                ->chart([2, 2, 2, 2, 2, 2, 2]),
        ];
    }
}
