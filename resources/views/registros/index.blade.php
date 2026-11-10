@extends('layouts.app')

@section('title', 'Registros Anexo A | SANTRIX ANEXO LOCAL')
@section('page-title', 'Registros Anexo A')

@push('styles')
<style>
    .rx-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; flex-wrap: wrap; margin-bottom: 20px; }
    .rx-head h3 { margin: 0; font-size: 20px; font-weight: 800; }
    .rx-head p { margin: 4px 0 0; font-size: 13px; color: var(--muted); max-width: 560px; }
    .rx-btns { display: flex; flex-wrap: wrap; gap: 10px; }
    .rx-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 9px;
        font-size: 13.5px; font-weight: 600; text-decoration: none; cursor: pointer; transition: background .2s;
        background: #fff; color: var(--navy); border: 1px solid #dce3eb; font-family: inherit;
    }
    .rx-btn:hover { background: #f3f6fa; }
    .rx-btn.rx-main { background: var(--blue); color: #fff; border-color: var(--blue); }
    .rx-btn.rx-main:hover { background: var(--navy-light); }

    .rx-panel { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; box-shadow: 0 2px 10px #19365208; margin-bottom: 20px; }
    .rx-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
    .rx-grid-main { grid-template-columns: 2fr 1fr 1fr; }
    .rx-lbl { display: block; font-size: 12px; font-weight: 600; color: #5a6b80; margin-bottom: 6px; }
    .rx-in { width: 100%; background: #fff; }
    .rx-search { position: relative; }
    .rx-search i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 17px; }
    .rx-search input { padding-left: 38px; }

    .rx-more { margin-top: 16px; border-top: 1px solid var(--border); padding-top: 14px; }
    .rx-more summary { cursor: pointer; font-size: 13.5px; font-weight: 600; color: var(--blue); list-style: none; display: flex; align-items: center; gap: 8px; }
    .rx-more summary::-webkit-details-marker { display: none; }
    .rx-more[open] summary i.rx-chev { transform: rotate(180deg); }
    .rx-more summary i.rx-chev { transition: transform .2s; }
    .rx-count { background: var(--blue); color: #fff; border-radius: 20px; font-size: 11px; padding: 1px 8px; }
    .rx-more .rx-grid { margin-top: 14px; }

    .rx-filter-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }

    .rx-bar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
    .rx-bar span { font-size: 13px; color: var(--muted); }

    .rx-table-wrap { overflow-x: auto; }
    .rx-table th { white-space: nowrap; }
    .rx-table td { vertical-align: middle; }
    .rx-table .rx-strong { font-weight: 700; }
    .rx-table .rx-small { font-size: 12px; color: var(--muted); }
    .rx-table input[type=checkbox] { width: 16px; height: 16px; cursor: pointer; }

    .rx-acts { display: flex; gap: 6px; align-items: center; }
    .rx-act {
        width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #dce3eb; background: #fff; color: #4a5b70; font-size: 17px; cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .rx-act:hover { background: #eef4fa; color: var(--blue); border-color: #b9d3ea; }
    .rx-act.rx-del:hover { background: #fdecea; color: #c0392b; border-color: #f2b8b2; }
    .rx-acts form { margin: 0; }

    .rx-empty { text-align: center; padding: 50px 20px; color: var(--muted); }
    .rx-empty i { font-size: 44px; color: #b8c5d3; }
    .rx-empty strong { display: block; color: var(--text); font-size: 17px; margin: 10px 0 4px; }
    .rx-pager { margin-top: 20px; }

    @media (max-width: 800px) { .rx-grid-main { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    @php
        $avanzados = ['fecha', 'fecha_desde', 'fecha_hasta', 'mes', 'anio', 'visitado', 'efectividad', 'tipo_supervision_fiscalizacion', 'nombre_apellido_personal_es'];
        $activos = collect($avanzados)->filter(fn ($k) => request()->filled($k))->count();
        $totalRegistros = method_exists($registros, 'total') ? $registros->total() : $registros->count();
    @endphp

    <div class="rx-head">
        <div>
            <h3>Listado de registros</h3>
            <p>La exportación por fecha usa la fecha de creación del registro en el sistema, no las fechas internas del Excel.</p>
        </div>
        <div class="rx-btns">
            <a href="{{ route('registros.create') }}" class="rx-btn rx-main"><i class="ti ti-plus"></i>Nuevo registro</a>
            <a href="{{ route('registros.exportar.hoy') }}" class="rx-btn"><i class="ti ti-download"></i>Exportar de hoy</a>
            <a href="{{ route('registros.exportar.todo') }}" class="rx-btn"><i class="ti ti-file-export"></i>Exportar todo</a>
        </div>
    </div>

    <section class="rx-panel">
        <form method="GET" action="{{ route('registros.index') }}">
            <div class="rx-grid rx-grid-main">
                <div>
                    <label class="rx-lbl" for="buscar">Búsqueda</label>
                    <div class="rx-search">
                        <i class="ti ti-search"></i>
                        <input class="rx-in" type="text" id="buscar" name="buscar" value="{{ request('buscar') }}" placeholder="Razón social, informe, expediente, código OSINERGMIN o actividad">
                    </div>
                </div>
                <div>
                    <label class="rx-lbl" for="estado_entregable">{{ config('anexo.column_labels.estado_entregable') }}</label>
                    <select class="rx-in" id="estado_entregable" name="estado_entregable">
                        <option value="">Todos</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado }}" @selected(request('estado_entregable') === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="rx-lbl" for="anexo_id">Anexo</label>
                    <select class="rx-in" id="anexo_id" name="anexo_id">
                        <option value="">Todos</option>
                        @foreach ($anexos as $anexo)
                            <option value="{{ $anexo->id }}" @selected((string) request('anexo_id') === (string) $anexo->id)>#{{ $anexo->id }} - {{ $anexo->titulo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <details class="rx-more" @if ($activos > 0) open @endif>
                <summary>
                    <i class="ti ti-adjustments-horizontal"></i>Más filtros
                    @if ($activos > 0)<span class="rx-count">{{ $activos }}</span>@endif
                    <i class="ti ti-chevron-down rx-chev"></i>
                </summary>
                <div class="rx-grid">
                    <div>
                        <label class="rx-lbl" for="fecha">Fecha de registro en el sistema</label>
                        <input class="rx-in" type="date" id="fecha" name="fecha" value="{{ request('fecha') }}">
                    </div>
                    <div>
                        <label class="rx-lbl" for="fecha_desde">Desde fecha de registro</label>
                        <input class="rx-in" type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    </div>
                    <div>
                        <label class="rx-lbl" for="fecha_hasta">Hasta fecha de registro</label>
                        <input class="rx-in" type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div>
                        <label class="rx-lbl" for="mes">Mes de registro</label>
                        <select class="rx-in" id="mes" name="mes">
                            <option value="">Todos</option>
                            @foreach ($meses as $numeroMes => $nombreMes)
                                <option value="{{ $numeroMes }}" @selected((string) request('mes') === (string) $numeroMes)>{{ $nombreMes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="rx-lbl" for="anio">Año</label>
                        <select class="rx-in" id="anio" name="anio">
                            <option value="">Todos</option>
                            @foreach ($anios as $anio)
                                <option value="{{ $anio }}" @selected((string) request('anio') === (string) $anio)>{{ $anio }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="rx-lbl" for="visitado">{{ config('anexo.column_labels.visitado') }}</label>
                        <select class="rx-in" id="visitado" name="visitado">
                            <option value="">Todos</option>
                            <option value="1" @selected(request('visitado') === '1')>Sí</option>
                            <option value="0" @selected(request('visitado') === '0')>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="rx-lbl" for="efectividad">{{ config('anexo.column_labels.efectividad') }}</label>
                        <select class="rx-in" id="efectividad" name="efectividad">
                            <option value="">Todos</option>
                            <option value="1" @selected(request('efectividad') === '1')>Sí</option>
                            <option value="0" @selected(request('efectividad') === '0')>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="rx-lbl" for="tipo_supervision_fiscalizacion">{{ config('anexo.column_labels.tipo_supervision') }}</label>
                        <select class="rx-in" id="tipo_supervision_fiscalizacion" name="tipo_supervision_fiscalizacion">
                            <option value="">Todos</option>
                            @foreach ($tiposSupervision as $tipo)
                                <option value="{{ $tipo }}" @selected(request('tipo_supervision_fiscalizacion', request('tipo_supervision')) === $tipo)>{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="rx-lbl" for="nombre_apellido_personal_es">{{ config('anexo.column_labels.personal_es') }}</label>
                        <select class="rx-in" id="nombre_apellido_personal_es" name="nombre_apellido_personal_es">
                            <option value="">Todos</option>
                            @foreach ($personalEsOptions as $personal)
                                <option value="{{ $personal }}" @selected(request('nombre_apellido_personal_es', request('personal_es')) === $personal)>{{ $personal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </details>

            <div class="rx-filter-actions">
                <button type="submit" class="rx-btn rx-main"><i class="ti ti-filter"></i>Filtrar</button>
                <a href="{{ route('registros.index') }}" class="rx-btn"><i class="ti ti-eraser"></i>Limpiar filtros</a>
                <button type="submit" formaction="{{ route('registros.exportar.filtrado') }}" formmethod="GET" class="rx-btn"><i class="ti ti-file-spreadsheet"></i>Exportar resultado filtrado</button>
            </div>
        </form>
    </section>

    <form id="export-selected-form" method="POST" action="{{ route('registros.exportar.seleccionados') }}" style="display: none;">
        @csrf
        <input type="hidden" name="anexo_id" value="{{ request('anexo_id') }}">
    </form>

    <section class="rx-panel">
        @if ($registros->isEmpty())
            <div class="rx-empty">
                <i class="ti ti-inbox"></i>
                <strong>No se encontraron registros</strong>
                <span>Ajusta los filtros o crea un nuevo registro para empezar.</span>
            </div>
        @else
            <div class="rx-bar">
                <span><i class="ti ti-info-circle"></i> {{ $totalRegistros }} registros encontrados. Marca las filas que quieras incluir en un solo Excel.</span>
                <button type="submit" form="export-selected-form" class="rx-btn rx-main"><i class="ti ti-file-export"></i>Exportar seleccionados</button>
            </div>

            <div class="rx-table-wrap">
                <table class="rx-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="rx-all" aria-label="Seleccionar todos"></th>
                            <th>Anexo</th>
                            <th>Fecha de registro</th>
                            <th>{{ config('anexo.column_labels.item') }}</th>
                            <th>{{ config('anexo.column_labels.codigo_unidad') }}</th>
                            <th>{{ config('anexo.column_labels.numero_documento') }}</th>
                            <th>{{ config('anexo.column_labels.razon_social_agente') }}</th>
                            <th>{{ config('anexo.column_labels.tipo_supervision') }}</th>
                            <th>{{ config('anexo.column_labels.numero_informe') }}</th>
                            <th>{{ config('anexo.column_labels.estado_entregable') }}</th>
                            <th>{{ config('anexo.column_labels.visitado') }}</th>
                            <th>{{ config('anexo.column_labels.efectividad') }}</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                            <tr>
                                <td>
                                    <input type="checkbox" class="rx-check" name="registros_ids[]" value="{{ $registro->id }}" form="export-selected-form">
                                </td>
                                <td class="rx-strong">
                                    <a href="{{ route('anexos.show', $registro->anexo) }}" style="text-decoration: none; color: inherit;">
                                        {{ $registro->anexo?->titulo ?: 'Sin anexo' }}
                                    </a>
                                </td>
                                <td>
                                    {{ $registro->created_at?->format('d/m/Y') ?: 'Sin dato' }}
                                    <div class="rx-small">{{ $registro->created_at?->format('H:i') }}</div>
                                </td>
                                <td class="rx-strong">{{ $registro->item }}</td>
                                <td>{{ $registro->codigo_unidad ?: 'Sin dato' }}</td>
                                <td>{{ $registro->numero_documento ?: 'Sin dato' }}</td>
                                <td>{{ $registro->razon_social_agente ?: 'Sin dato' }}</td>
                                <td>{{ $registro->tipo_supervision ?: 'Sin dato' }}</td>
                                <td>{{ $registro->numero_informe ?: 'Sin dato' }}</td>
                                <td><x-status-badge :value="$registro->estado_entregable" /></td>
                                <td><x-boolean-badge :value="$registro->visitado" /></td>
                                <td><x-boolean-badge :value="$registro->efectividad" /></td>
                                <td>
                                    <div class="rx-acts">
                                        <a href="{{ route('registros.show', $registro) }}" class="rx-act" title="Ver"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('registros.edit', $registro) }}" class="rx-act" title="Editar"><i class="ti ti-pencil"></i></a>
                                        <a href="{{ route('registros.exportar.excel', $registro) }}" class="rx-act" title="Exportar Excel"><i class="ti ti-file-spreadsheet"></i></a>
                                        <form action="{{ route('registros.destroy', $registro) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rx-act rx-del" title="Eliminar"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rx-pager">
                {{ $registros->links() }}
            </div>
        @endif
    </section>
@endsection

@push('scripts')
<script>
    var todos = document.getElementById('rx-all');
    if (todos) {
        todos.addEventListener('change', function () {
            document.querySelectorAll('.rx-check').forEach(function (c) { c.checked = todos.checked; });
        });
    }
</script>
@endpush
