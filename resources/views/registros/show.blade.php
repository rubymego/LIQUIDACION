@extends('layouts.app')

@section('title', 'Detalle de registro | SANTRIX ANEXO LOCAL')
@section('page-title', 'Detalle de registro')

@push('styles')
<style>
    .vx-wrap { max-width: 1100px; margin: 0 auto; }
    .vx-hero { background: linear-gradient(135deg, #10243b 0%, #1675b9 100%); color: #fff; border-radius: 16px; padding: 26px 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap; }
    .vx-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2px; color: #9fd8ea; text-transform: uppercase; }
    .vx-hero h2 { font-size: 22px; font-weight: 800; margin: 8px 0 4px; line-height: 1.3; }
    .vx-hero p { margin: 0; color: #cfe3f1; font-size: 14px; }
    .vx-state { margin-top: 12px; }
    .vx-btns { display: flex; flex-wrap: wrap; gap: 10px; }
    .vx-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 9px; font-size: 13.5px; font-weight: 600; text-decoration: none; background: #fff; color: var(--navy); border: 1px solid #dce3eb; transition: background .2s; }
    .vx-btn:hover { background: #f3f6fa; }
    .vx-btn.vx-main { background: #fff; color: var(--blue); border-color: #fff; }

    .vx-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px 24px; box-shadow: 0 2px 10px #19365208; margin-bottom: 20px; }
    .vx-head { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border); }
    .vx-ico { width: 40px; height: 40px; border-radius: 11px; background: #e8f2fa; color: var(--blue); display: grid; place-items: center; font-size: 20px; flex-shrink: 0; }
    .vx-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .vx-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px 24px; }
    .vx-wide { grid-column: 1 / -1; }
    .vx-lbl { font-size: 12px; color: var(--muted); margin-bottom: 4px; }
    .vx-val { font-size: 15px; font-weight: 600; word-break: break-word; }
    .vx-val a { color: var(--blue); text-decoration: none; }
    .vx-val a:hover { color: var(--navy); }
    .vx-text { white-space: pre-line; font-weight: 400; line-height: 1.6; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 12px 14px; }
</style>
@endpush

@section('content')
    <div class="vx-wrap">
        <section class="vx-hero">
            <div>
                <div class="vx-eyebrow">Registro item {{ $registro->item }}</div>
                <h2>{{ $registro->razon_social_agente ?: 'Sin razón social' }}</h2>
                <p>Detalle completo de la fila del Anexo A.</p>
                <div class="vx-state"><x-status-badge :value="$registro->estado_entregable" /></div>
            </div>
            <div class="vx-btns">
                <a href="{{ route('registros.edit', $registro) }}" class="vx-btn vx-main"><i class="ti ti-pencil"></i>Editar</a>
                <a href="{{ route('registros.exportar.excel', $registro) }}" class="vx-btn"><i class="ti ti-file-spreadsheet"></i>Exportar Excel</a>
                <a href="{{ route('registros.index') }}" class="vx-btn"><i class="ti ti-arrow-left"></i>Volver</a>
            </div>
        </section>

        <section class="vx-card">
            <div class="vx-head"><div class="vx-ico"><i class="ti ti-clipboard-list"></i></div><h3>Datos de asignación</h3></div>
            <div class="vx-grid">
                <div><div class="vx-lbl">Anexo</div><div class="vx-val"><a href="{{ route('anexos.show', $registro->anexo) }}">{{ $registro->anexo?->titulo ?: 'Sin anexo' }}</a></div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.item') }}</div><div class="vx-val">{{ $registro->item }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.codigo_unidad') }}</div><div class="vx-val">{{ $registro->codigo_unidad ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.expediente_siged') }}</div><div class="vx-val">{{ $registro->expediente_siged ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.fecha_asignacion') }}</div><div class="vx-val">{{ $registro->fecha_asignacion?->format('d/m/Y') ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.numero_documento') }}</div><div class="vx-val">{{ $registro->numero_documento ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.codigo_osinergmin') }}</div><div class="vx-val">{{ $registro->codigo_osinergmin ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.codigo_actividad') }}</div><div class="vx-val">{{ $registro->codigo_actividad ?: 'Sin dato' }}</div></div>
            </div>
        </section>

        <section class="vx-card">
            <div class="vx-head"><div class="vx-ico"><i class="ti ti-building-store"></i></div><h3>Datos del agente</h3></div>
            <div class="vx-grid">
                <div class="vx-wide"><div class="vx-lbl">{{ config('anexo.column_labels.razon_social_agente') }}</div><div class="vx-val">{{ $registro->razon_social_agente ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.personal_es') }}</div><div class="vx-val">{{ $registro->personal_es ?: 'Sin dato' }}</div></div>
            </div>
        </section>

        <section class="vx-card">
            <div class="vx-head"><div class="vx-ico"><i class="ti ti-shield-check"></i></div><h3>Supervisión/Fiscalización</h3></div>
            <div class="vx-grid">
                <div><div class="vx-lbl">{{ config('anexo.column_labels.tipo_supervision') }}</div><div class="vx-val">{{ $registro->tipo_supervision ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.tipo_entregable') }}</div><div class="vx-val">{{ $registro->tipo_entregable ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.numero_informe') }}</div><div class="vx-val">{{ $registro->numero_informe ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.visitado') }}</div><div class="vx-val"><x-boolean-badge :value="$registro->visitado" /></div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.efectividad') }}</div><div class="vx-val"><x-boolean-badge :value="$registro->efectividad" /></div></div>
            </div>
        </section>

        <section class="vx-card">
            <div class="vx-head"><div class="vx-ico"><i class="ti ti-calendar-event"></i></div><h3>Fechas y estado</h3></div>
            <div class="vx-grid">
                <div><div class="vx-lbl">{{ config('anexo.column_labels.fecha_visita') }}</div><div class="vx-val">{{ $registro->fecha_visita?->format('d/m/Y') ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.fecha_derivacion') }}</div><div class="vx-val">{{ $registro->fecha_derivacion?->format('d/m/Y') ?: 'Sin dato' }}</div></div>
                <div><div class="vx-lbl">{{ config('anexo.column_labels.estado_entregable') }}</div><div class="vx-val"><x-status-badge :value="$registro->estado_entregable" /></div></div>
            </div>
        </section>

        <section class="vx-card">
            <div class="vx-head"><div class="vx-ico"><i class="ti ti-notes"></i></div><h3>Observaciones</h3></div>
            <div class="vx-grid">
                <div class="vx-wide"><div class="vx-lbl">{{ config('anexo.column_labels.observaciones') }}</div><div class="vx-val vx-text">{{ $registro->observaciones ?: 'Sin dato' }}</div></div>
                <div class="vx-wide"><div class="vx-lbl">{{ config('anexo.column_labels.comentarios') }}</div><div class="vx-val vx-text">{{ $registro->comentarios ?: 'Sin dato' }}</div></div>
            </div>
        </section>
    </div>
@endsection
