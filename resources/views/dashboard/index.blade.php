@extends('layouts.app')

@section('title', 'Dashboard | SANTRIX ANEXO LOCAL')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .dx-hero {
        background: linear-gradient(135deg, #10243b 0%, #1675b9 100%);
        color: #fff;
        border-radius: 16px;
        padding: 28px 30px;
        margin-bottom: 20px;
    }
    .dx-hero .dx-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2px; color: #9fd8ea; text-transform: uppercase; }
    .dx-hero h2 { font-size: 22px; font-weight: 800; margin: 8px 0 6px; line-height: 1.3; }
    .dx-hero p { margin: 0; color: #cfe3f1; font-size: 14px; }

    .dx-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px; }
    .dx-info-item {
        background: #fff; border: 1px solid var(--border); border-radius: 14px;
        padding: 16px 18px; display: flex; align-items: center; gap: 14px;
    }
    .dx-info-item .dx-ico {
        width: 42px; height: 42px; border-radius: 11px; display: grid; place-items: center;
        background: #e8f2fa; color: var(--blue); font-size: 21px; flex-shrink: 0;
    }
    .dx-info-item .dx-lbl { font-size: 12px; color: var(--muted); }
    .dx-info-item .dx-val { font-size: 15px; font-weight: 700; margin-top: 2px; word-break: break-word; }
    .dx-wide { grid-column: 1 / -1; }

    .dx-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 20px; }
    .dx-stat {
        border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px;
        text-decoration: none; transition: transform .15s;
    }
    a.dx-stat:hover { transform: translateY(-2px); }
    .dx-stat i { font-size: 36px; }
    .dx-stat .dx-n { font-size: 34px; font-weight: 800; line-height: 1.1; }
    .dx-stat .dx-t { font-size: 13px; font-weight: 500; }
    .dx-blue { background: #e3f0fb; color: #0e5a96; }
    .dx-green { background: #e6f6ef; color: #0f6b4e; }
    .dx-teal { background: #e0f4f8; color: #0b6a80; }

    .dx-groups { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px; }
    .dx-group { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; }
    .dx-group h3 { font-size: 14px; font-weight: 700; margin: 0 0 16px; display: flex; align-items: center; gap: 8px; }
    .dx-group h3 i { color: var(--blue); font-size: 18px; }
    .dx-row { margin-bottom: 14px; }
    .dx-row:last-child { margin-bottom: 0; }
    .dx-row-top { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; }
    .dx-row-top span:last-child { color: var(--muted); }
    .dx-bar { height: 8px; background: #edf1f6; border-radius: 6px; overflow: hidden; }
    .dx-bar div { height: 100%; border-radius: 6px; }

    .dx-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .dx-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 17px; border-radius: 9px;
        font-size: 13.5px; font-weight: 600; text-decoration: none; transition: background .2s;
        background: #fff; color: var(--navy); border: 1px solid #dce3eb;
    }
    .dx-btn:hover { background: #f3f6fa; }
    .dx-btn.dx-main { background: var(--blue); color: #fff; border-color: var(--blue); }
    .dx-btn.dx-main:hover { background: var(--navy-light); }

    .dx-panel { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px #19365208; }
    .dx-panel-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
    .dx-panel-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .dx-panel-head p { margin: 4px 0 0; font-size: 13px; color: var(--muted); }
    .dx-link { color: var(--blue); font-weight: 600; text-decoration: none; font-size: 13px; }
    .dx-link:hover { color: var(--navy); }
    .dx-empty { text-align: center; padding: 40px 20px; color: var(--muted); }
    .dx-empty i { font-size: 40px; color: #b8c5d3; }
    .dx-empty strong { display: block; color: var(--text); font-size: 16px; margin: 8px 0 4px; }
</style>
@endpush

@section('content')
    @php
        $total = max($metricas['total_registros'], 1);
        $pct = fn ($n) => round($n * 100 / $total);
        $grupos = [
            [
                'titulo' => 'Avance de entregables',
                'icono' => 'ti-progress-check',
                'items' => [
                    ['Concluidos', $metricas['registros_concluidos'], '#1d9e75'],
                    ['En proceso', $metricas['registros_en_proceso'], '#d69e2e'],
                ],
            ],
            [
                'titulo' => 'Visitas',
                'icono' => 'ti-map-pin-check',
                'items' => [
                    ['Visitados', $metricas['visitados'], '#1675b9'],
                    ['No visitados', $metricas['no_visitados'], '#a0aec0'],
                ],
            ],
            [
                'titulo' => 'Efectividad',
                'icono' => 'ti-target-arrow',
                'items' => [
                    ['Efectivos', $metricas['efectivos'], '#1d9e75'],
                    ['No efectivos', $metricas['no_efectivos'], '#e24b4a'],
                ],
            ],
        ];
    @endphp

    <section class="dx-hero">
        <div class="dx-eyebrow">Cabecera institucional fija</div>
        <h2>{{ config('anexo.title') }}</h2>
        <p>{{ $configuracion['empresa'] }}</p>
    </section>

    <div class="dx-info">
        <div class="dx-info-item">
            <div class="dx-ico"><i class="ti ti-id"></i></div>
            <div>
                <div class="dx-lbl">{{ config('anexo.entregable_labels.ruc') }}</div>
                <div class="dx-val">{{ $configuracion['ruc'] }}</div>
            </div>
        </div>
        <div class="dx-info-item">
            <div class="dx-ico"><i class="ti ti-file-text"></i></div>
            <div>
                <div class="dx-lbl">{{ config('anexo.entregable_labels.numero_contrato') }}</div>
                <div class="dx-val">{{ $configuracion['contrato'] }}</div>
            </div>
        </div>
        <div class="dx-info-item">
            <div class="dx-ico"><i class="ti ti-map-pin"></i></div>
            <div>
                <div class="dx-lbl">División</div>
                <div class="dx-val">{{ $configuracion['division'] ?: 'Sin dato' }}</div>
            </div>
        </div>
        <div class="dx-info-item dx-wide">
            <div class="dx-ico"><i class="ti ti-briefcase"></i></div>
            <div>
                <div class="dx-lbl">{{ config('anexo.entregable_labels.nombre_servicio') }}</div>
                <div class="dx-val">{{ $configuracion['nombre_servicio_contratado'] }}</div>
            </div>
        </div>
    </div>

    <div class="dx-stats">
        <a href="{{ route('anexos.index') }}" class="dx-stat dx-blue">
            <i class="ti ti-files"></i>
            <div>
                <div class="dx-t">Total de anexos</div>
                <div class="dx-n">{{ $metricas['total_anexos'] }}</div>
            </div>
        </a>
        <a href="{{ route('registros.index') }}" class="dx-stat dx-green">
            <i class="ti ti-list-check"></i>
            <div>
                <div class="dx-t">Total de registros</div>
                <div class="dx-n">{{ $metricas['total_registros'] }}</div>
            </div>
        </a>
        <a href="{{ route('registros.exportar.hoy') }}" class="dx-stat dx-teal">
            <i class="ti ti-calendar-plus"></i>
            <div>
                <div class="dx-t">Registros creados hoy</div>
                <div class="dx-n">{{ $metricas['registros_hoy'] }}</div>
            </div>
        </a>
    </div>

    <div class="dx-groups">
        @foreach ($grupos as $grupo)
            <div class="dx-group">
                <h3><i class="ti {{ $grupo['icono'] }}"></i>{{ $grupo['titulo'] }}</h3>
                @foreach ($grupo['items'] as $item)
                    <div class="dx-row">
                        <div class="dx-row-top">
                            <span>{{ $item[0] }}</span>
                            <span>{{ $item[1] }} ({{ $pct($item[1]) }}%)</span>
                        </div>
                        <div class="dx-bar"><div style="width: {{ $pct($item[1]) }}%; background: {{ $item[2] }};"></div></div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="dx-charts">
        <div class="dx-panel">
            <div class="dx-panel-head"><div><h3>Estado de los registros</h3><p>Concluidos, en proceso y otros.</p></div></div>
            <div style="position: relative; height: 260px;"><canvas id="graficoEstado"></canvas></div>
        </div>
        <div class="dx-panel">
            <div class="dx-panel-head"><div><h3>Visitas y efectividad</h3><p>Comparación sobre el total de registros.</p></div></div>
            <div style="position: relative; height: 260px;"><canvas id="graficoVisitas"></canvas></div>
        </div>
    </div>

    <div class="dx-actions">
        <a href="{{ route('registros.create') }}" class="dx-btn dx-main"><i class="ti ti-plus"></i>Nuevo registro</a>
        <a href="{{ route('registros.exportar.hoy') }}" class="dx-btn"><i class="ti ti-download"></i>Exportar registros de hoy</a>
        <a href="{{ route('registros.exportar.todo') }}" class="dx-btn"><i class="ti ti-file-export"></i>Exportar todo</a>
        <a href="{{ route('importaciones.create') }}" class="dx-btn"><i class="ti ti-upload"></i>Importar Excel</a>
    </div>

    <section class="dx-panel">
        <div class="dx-panel-head">
            <div>
                <h3>Últimos 10 registros</h3>
                <p>Vista rápida del movimiento reciente del Anexo A.</p>
            </div>
            <a href="{{ route('registros.index') }}" class="dx-link">Ver todos <i class="ti ti-arrow-right"></i></a>
        </div>

        @if ($ultimosRegistros->isEmpty())
            <div class="dx-empty">
                <i class="ti ti-inbox"></i>
                <strong>No hay registros aún</strong>
                <span>La cabecera base ya está lista. Solo necesitas registrar filas del Anexo A.</span>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Anexo</th>
                            <th>{{ config('anexo.column_labels.item') }}</th>
                            <th>{{ config('anexo.column_labels.razon_social_agente') }}</th>
                            <th>{{ config('anexo.column_labels.tipo_supervision') }}</th>
                            <th>{{ config('anexo.column_labels.estado_entregable') }}</th>
                            <th>{{ config('anexo.column_labels.visitado') }}</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ultimosRegistros as $registro)
                            <tr>
                                <td style="font-weight: 600;">
                                    <a href="{{ route('anexos.show', $registro->anexo) }}" class="dx-link" style="color: inherit;">
                                        {{ $registro->anexo?->titulo ?: 'Sin anexo' }}
                                    </a>
                                </td>
                                <td style="font-weight: 600;">{{ $registro->item }}</td>
                                <td>{{ $registro->razon_social_agente ?: 'Sin dato' }}</td>
                                <td>{{ $registro->tipo_supervision ?: 'Sin dato' }}</td>
                                <td><x-status-badge :value="$registro->estado_entregable" /></td>
                                <td><x-boolean-badge :value="$registro->visitado" /></td>
                                <td><a href="{{ route('registros.show', $registro) }}" class="dx-link">Ver detalle</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection


@push('styles')
<style>
    .dx-charts { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px; margin-bottom: 20px; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    var concluidos = {{ $metricas['registros_concluidos'] }};
    var enProceso = {{ $metricas['registros_en_proceso'] }};
    var otros = {{ max($metricas['total_registros'] - $metricas['registros_concluidos'] - $metricas['registros_en_proceso'], 0) }};

    new Chart(document.getElementById('graficoEstado'), {
        type: 'doughnut',
        data: {
            labels: ['Concluidos', 'En proceso', 'Otros'],
            datasets: [{ data: [concluidos, enProceso, otros], backgroundColor: ['#1d9e75', '#d69e2e', '#a0aec0'], borderWidth: 0 }]
        },
        options: { maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('graficoVisitas'), {
        type: 'bar',
        data: {
            labels: ['Visitados', 'No visitados', 'Efectivos', 'No efectivos'],
            datasets: [{
                data: [{{ $metricas['visitados'] }}, {{ $metricas['no_visitados'] }}, {{ $metricas['efectivos'] }}, {{ $metricas['no_efectivos'] }}],
                backgroundColor: ['#1675b9', '#a0aec0', '#1d9e75', '#e24b4a'],
                borderRadius: 6
            }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
    });
</script>
@endpush
