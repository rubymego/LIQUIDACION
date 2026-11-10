@php
    $editing = isset($anexo);
@endphp

@push('styles')
<style>
    .af-wrap { max-width: 1000px; margin: 0 auto; }
    .af-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px 24px; box-shadow: 0 2px 10px #19365208; margin-bottom: 20px; }
    .af-head { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
    .af-ico { width: 42px; height: 42px; border-radius: 11px; background: #e8f2fa; color: var(--blue); display: grid; place-items: center; font-size: 21px; flex-shrink: 0; }
    .af-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .af-head p { margin: 3px 0 0; font-size: 13px; color: var(--muted); }
    .af-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .af-2 { grid-column: span 2; }
    .af-3 { grid-column: 1 / -1; }
    .af-lbl { display: block; font-size: 12px; font-weight: 600; color: #5a6b80; margin-bottom: 6px; }
    .af-in { width: 100%; background: #fff; }
    .af-actions { display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }
    .af-btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 9px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; font-family: inherit; background: #fff; color: var(--navy); border: 1px solid #dce3eb; transition: background .2s; }
    .af-btn:hover { background: #f3f6fa; }
    .af-btn.af-main { background: var(--blue); color: #fff; border-color: var(--blue); }
    .af-btn.af-main:hover { background: var(--navy-light); }
    @media (max-width: 800px) { .af-grid { grid-template-columns: 1fr; } .af-2 { grid-column: auto; } }
</style>
@endpush

<div class="af-wrap">
    <section class="af-card">
        <div class="af-head">
            <div class="af-ico"><i class="ti ti-file-description"></i></div>
            <div>
                <h3>Datos del anexo</h3>
                <p>La empresa es única. Aquí administras cada anexo y sus fechas operativas.</p>
            </div>
        </div>

        <div class="af-grid">
            <div class="af-2">
                <label class="af-lbl" for="titulo">Título del anexo</label>
                <input class="af-in" type="text" id="titulo" name="titulo" value="{{ old('titulo', $anexo->titulo ?? '') }}" required>
            </div>
            <div>
                <label class="af-lbl" for="responsable">Responsable</label>
                <input class="af-in" type="text" id="responsable" name="responsable" value="{{ old('responsable', $anexo->responsable ?? '') }}">
            </div>
        </div>
    </section>

    <section class="af-card">
        <div class="af-head">
            <div class="af-ico"><i class="ti ti-calendar-event"></i></div>
            <div>
                <h3>Fechas y estado</h3>
                <p>Estos datos cambian por cada anexo y se reflejan en la exportación Excel.</p>
            </div>
        </div>

        <div class="af-grid">
            <div class="af-3">
                <label class="af-lbl" for="periodo_ejecucion_contractual">{{ config('anexo.entregable_labels.periodo') }}</label>
                <input class="af-in" type="text" id="periodo_ejecucion_contractual" name="periodo_ejecucion_contractual" value="{{ old('periodo_ejecucion_contractual', $anexo->periodo_ejecucion_contractual ?? '') }}" placeholder="DESDE EL 18 DE NOVIEMBRE DE 2024 AL 17 DE DICIEMBRE DE 2024">
            </div>
            <div class="af-2">
                <label class="af-lbl" for="fecha_contractual_ingreso_entregable">{{ config('anexo.entregable_labels.fecha_ingreso_entregable') }}</label>
                <input class="af-in" type="date" id="fecha_contractual_ingreso_entregable" name="fecha_contractual_ingreso_entregable" value="{{ old('fecha_contractual_ingreso_entregable', isset($anexo) && $anexo->fecha_contractual_ingreso_entregable ? $anexo->fecha_contractual_ingreso_entregable->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="af-lbl" for="estado">Estado</label>
                <select class="af-in" id="estado" name="estado">
                    <option value="">Selecciona</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}" @selected(old('estado', $anexo->estado ?? '') === $estado)>{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    <div class="af-actions">
        <a href="{{ $editing ? route('anexos.show', $anexo) : route('anexos.index') }}" class="af-btn"><i class="ti ti-arrow-left"></i>Volver</a>
        <button type="submit" class="af-btn af-main"><i class="ti ti-device-floppy"></i>{{ $editing ? 'Actualizar anexo' : 'Guardar anexo' }}</button>
    </div>
</div>
