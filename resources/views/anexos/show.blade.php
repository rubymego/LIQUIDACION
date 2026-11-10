@extends('layouts.app')

@section('title', 'Configuración del Anexo | SANTRIX ANEXO LOCAL')
@section('page-title', 'Configuración del Anexo')

@push('styles')
<style>
    .sx-wrap { max-width: 1200px; margin: 0 auto; }
    .sx-hero { background: linear-gradient(135deg, #10243b 0%, #1675b9 100%); color: #fff; border-radius: 16px; padding: 26px 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap; }
    .sx-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2px; color: #9fd8ea; text-transform: uppercase; }
    .sx-hero h2 { font-size: 22px; font-weight: 800; margin: 8px 0 4px; line-height: 1.3; }
    .sx-hero p { margin: 0; color: #cfe3f1; font-size: 14px; }
    .sx-state { margin-top: 12px; }
    .sx-btns { display: flex; flex-wrap: wrap; gap: 10px; }
    .sx-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 9px; font-size: 13.5px; font-weight: 600; text-decoration: none; background: #fff; color: var(--navy); border: 1px solid #dce3eb; transition: background .2s; }
    .sx-btn:hover { background: #f3f6fa; }
    .sx-btn.sx-main { color: var(--blue); border-color: #fff; }

    .sx-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px 24px; box-shadow: 0 2px 10px #19365208; margin-bottom: 20px; }
    .sx-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border); }
    .sx-head-l { display: flex; align-items: center; gap: 14px; }
    .sx-ico { width: 40px; height: 40px; border-radius: 11px; background: #e8f2fa; color: var(--blue); display: grid; place-items: center; font-size: 20px; flex-shrink: 0; }
    .sx-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .sx-head p { margin: 3px 0 0; font-size: 13px; color: var(--muted); }
    .sx-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px 24px; }
    .sx-wide { grid-column: 1 / -1; }
    .sx-lbl { font-size: 12px; color: var(--muted); margin-bottom: 4px; }
    .sx-val { font-size: 15px; font-weight: 600; word-break: break-word; }
    .sx-link { color: var(--blue); font-weight: 600; text-decoration: none; font-size: 13px; }
    .sx-link:hover { color: var(--navy); }

    .sx-table-wrap { overflow-x: auto; }
    .sx-table td { vertical-align: middle; }
    .sx-strong { font-weight: 700; }
    .sx-acts { display: flex; gap: 6px; align-items: center; }
    .sx-act { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #dce3eb; background: #fff; color: #4a5b70; font-size: 17px; text-decoration: none; transition: all .15s; }
    .sx-act:hover { background: #eef4fa; color: var(--blue); border-color: #b9d3ea; }

    .sx-empty { text-align: center; padding: 40px 20px; color: var(--muted); }
    .sx-empty i { font-size: 44px; color: #b8c5d3; }
    .sx-empty strong { display: block; color: var(--text); font-size: 17px; margin: 10px 0 4px; }
</style>
@endpush

@section('content')
    @php($pdfDisponible = class_exists(\Barryvdh\DomPDF\Facade\Pdf::class))

    <div class="sx-wrap">
        <section class="sx-hero">
            <div>
                <div class="sx-eyebrow">Anexo</div>
                <h2>{{ $anexo->titulo }}</h2>
                <p>{{ config('anexo.title') }}</p>
                <div class="sx-state"><x-status-badge :value="$anexo->estado" /></div>
            </div>
            <div class="sx-btns">
                <a href="{{ route('registros.create', ['anexo_id' => $anexo->id]) }}" class="sx-btn sx-main"><i class="ti ti-plus"></i>Nuevo registro</a>
                <a href="{{ route('anexos.exportar.excel', $anexo) }}" class="sx-btn"><i class="ti ti-file-spreadsheet"></i>Exportar Excel</a>
                @if ($pdfDisponible)
                    <a href="{{ route('anexos.exportar.pdf', $anexo) }}" class="sx-btn"><i class="ti ti-file-type-pdf"></i>Exportar PDF</a>
                @endif
                <a href="{{ route('anexos.index') }}" class="sx-btn"><i class="ti ti-arrow-left"></i>Volver</a>
            </div>
        </section>

        <section class="sx-card">
            <div class="sx-head"><div class="sx-head-l"><div class="sx-ico"><i class="ti ti-building"></i></div><h3>Datos de la empresa</h3></div></div>
            <div class="sx-grid">
                <div class="sx-wide"><div class="sx-lbl">{{ config('anexo.entregable_labels.empresa_supervisora') }}</div><div class="sx-val">{{ $configuracion?->empresa ?: config('anexo.base_entregable.empresa_supervisora') }}</div></div>
                <div><div class="sx-lbl">{{ config('anexo.entregable_labels.ruc') }}</div><div class="sx-val">{{ $configuracion?->ruc ?: config('anexo.base_entregable.ruc') }}</div></div>
                <div><div class="sx-lbl">{{ config('anexo.entregable_labels.numero_contrato') }}</div><div class="sx-val">{{ $configuracion?->contrato ?: config('anexo.base_entregable.numero_contrato') }}</div></div>
                <div><div class="sx-lbl">DIVISION</div><div class="sx-val">{{ $configuracion?->division ?: config('anexo.base_entregable.division') ?: 'Sin dato' }}</div></div>
                <div class="sx-wide"><div class="sx-lbl">{{ config('anexo.entregable_labels.nombre_servicio') }}</div><div class="sx-val">{{ $configuracion?->nombre_servicio_contratado ?: config('anexo.base_entregable.nombre_servicio') }}</div></div>
            </div>
        </section>

        <section class="sx-card">
            <div class="sx-head"><div class="sx-head-l"><div class="sx-ico"><i class="ti ti-file-description"></i></div><h3>Datos del anexo</h3></div></div>
            <div class="sx-grid">
                <div class="sx-wide"><div class="sx-lbl">Título del anexo</div><div class="sx-val">{{ $anexo->titulo }}</div></div>
                <div class="sx-wide"><div class="sx-lbl">{{ config('anexo.entregable_labels.periodo') }}</div><div class="sx-val">{{ $anexo->periodo_ejecucion_contractual ?: 'Sin dato' }}</div></div>
                <div><div class="sx-lbl">{{ config('anexo.entregable_labels.fecha_ingreso_entregable') }}</div><div class="sx-val">{{ $anexo->fecha_contractual_ingreso_entregable?->format('d/m/Y') ?: 'Sin dato' }}</div></div>
                <div><div class="sx-lbl">Responsable</div><div class="sx-val">{{ $anexo->responsable ?: 'Sin dato' }}</div></div>
                <div><div class="sx-lbl">Estado</div><div class="sx-val"><x-status-badge :value="$anexo->estado" /></div></div>
            </div>
        </section>

        <section class="sx-card">
            <div class="sx-head">
                <div class="sx-head-l">
                    <div class="sx-ico"><i class="ti ti-list-details"></i></div>
                    <div>
                        <h3>Registros relacionados</h3>
                        <p>{{ $anexo->registros->count() }} fila(s) asociadas a este anexo.</p>
                    </div>
                </div>
            </div>

            @if ($anexo->registros->isEmpty())
                <div class="sx-empty">
                    <i class="ti ti-inbox"></i>
                    <strong>No hay registros asociados</strong>
                    <span>Puedes crear el primer registro directamente desde este anexo.</span>
                </div>
            @else
                <div class="sx-table-wrap">
                    <table class="sx-table">
                        <thead>
                            <tr>
                                <th>{{ config('anexo.column_labels.item') }}</th>
                                <th>{{ config('anexo.column_labels.razon_social_agente') }}</th>
                                <th>{{ config('anexo.column_labels.numero_informe') }}</th>
                                <th>{{ config('anexo.column_labels.estado_entregable') }}</th>
                                <th>{{ config('anexo.column_labels.visitado') }}</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anexo->registros as $registro)
                                <tr>
                                    <td class="sx-strong">{{ $registro->item }}</td>
                                    <td>{{ $registro->razon_social_agente ?: 'Sin dato' }}</td>
                                    <td>{{ $registro->numero_informe ?: 'Sin dato' }}</td>
                                    <td><x-status-badge :value="$registro->estado_entregable" /></td>
                                    <td><x-boolean-badge :value="$registro->visitado" /></td>
                                    <td>
                                        <div class="sx-acts">
                                            <a href="{{ route('registros.show', $registro) }}" class="sx-act" title="Ver"><i class="ti ti-eye"></i></a>
                                            <a href="{{ route('registros.edit', $registro) }}" class="sx-act" title="Editar"><i class="ti ti-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
