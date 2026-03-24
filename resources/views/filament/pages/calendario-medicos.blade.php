<x-filament-panels::page>

    <style>
        .calendario-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.5rem;
        }

        .dia-header {
            font-weight: bold;
            text-align: center;
            color: #6b7280;
            padding: 0.5rem 0;
        }

        .celda-dia {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem;
            min-height: 120px;
            background-color: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .turno-badge {
            font-size: 0.75rem;
            background-color: #fef3c7;
            /* Fondo amarillo claro */
            color: #b45309;
            /* Texto amarillo oscuro */
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
            line-height: 1.2;
        }

        /* Reglas automáticas para el Modo Oscuro */
        @media (prefers-color-scheme: dark) {
            .dia-header {
                color: #9ca3af;
            }

            .celda-dia {
                background-color: #111827;
                /* Fondo oscuro Filament */
                border-color: #374151;
            }

            .turno-badge {
                background-color: rgba(234, 179, 8, 0.1);
                color: #facc15;
            }
        }
    </style>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold tracking-tight capitalize text-gray-950 dark:text-white">
            {{$nombreMes}}
        </h2>
    </div>

    <div class=" calendario-grid">

        <!-- mostrar días -->
        @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $dia)
        <div class="dia-header">{{ $dia }}</div>
        @endforeach

        @for($i = 0; $i < $inicioMes->dayOfWeek; $i++)
            <div class="">
            </div>
            @endfor

            <!-- mostrar día del mes mes -->
            @foreach($diasMes as $dia)
            <div class="celda-dia">
                <div class="font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">
                    {{$dia['fecha']->format('d')}}
                </div>

                @if(isset($dia['turnos']))
                @foreach($dia['turnos'] as $turno)
                <div class="turno-badge">
                    <div style="font-weight:700; margin-bottom: 2px;">
                        {{$turno['medico']}}
                    </div>
                    <div style="opacity:0.85;">
                        {{$turno['hora']}}
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @endforeach
    </div>
</x-filament-panels::page>