@php
    $editing = isset($registro);
    $selectedAnexo = $anexos->firstWhere('id', (int) old('anexo_id', $selectedAnexoId ?? $registro->anexo_id ?? 0));
    $showAnexoSelector = $anexos->count() > 1;
@endphp

@push('styles')
<style>
    .fx-wrap { max-width: 1100px; margin: 0 auto; }
    .fx-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px 24px; box-shadow: 0 2px 10px #19365208; margin-bottom: 20px; }
    .fx-head { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
    .fx-ico { width: 42px; height: 42px; border-radius: 11px; background: #e8f2fa; color: var(--blue); display: grid; place-items: center; font-size: 21px; flex-shrink: 0; }
    .fx-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .fx-head p { margin: 3px 0 0; font-size: 13px; color: var(--muted); }
    .fx-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    .fx-2 { grid-column: span 2; }
    .fx-4 { grid-column: 1 / -1; }
    .fx-lbl { display: block; font-size: 12px; font-weight: 600; color: #5a6b80; margin-bottom: 6px; }
    .fx-in { width: 100%; background: #fff; }
    textarea.fx-in { resize: vertical; min-height: 120px; line-height: 1.5; }
    .fx-auto { background: #e0f4f8; border: 1px solid #b6e3ee; border-radius: 12px; padding: 12px 16px; color: #0b6a80; font-size: 13.5px; }
    .fx-auto strong { display: block; font-weight: 700; margin-bottom: 2px; }
    .fx-actions { display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap; padding-top: 4px; }
    .fx-btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 9px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; font-family: inherit; background: #fff; color: var(--navy); border: 1px solid #dce3eb; transition: background .2s; }
    .fx-btn:hover { background: #f3f6fa; }
    .fx-btn.fx-main { background: var(--blue); color: #fff; border-color: var(--blue); }
    .fx-btn.fx-main:hover { background: var(--navy-light); }
    @media (max-width: 900px) { .fx-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 560px) { .fx-grid { grid-template-columns: 1fr; } .fx-2 { grid-column: auto; } }
</style>
@endpush

<div class="fx-wrap">
    <section class="fx-card">
        <div class="fx-head">
            <div class="fx-ico"><i class="ti ti-clipboard-list"></i></div>
            <div>
                <h3>Datos de asignación</h3>
                <p>Puedes escribir el ITEM manualmente. Si lo dejas vacío, el sistema calculará el siguiente disponible para ese anexo.</p>
            </div>
        </div>

        <div class="fx-grid">
            @if ($showAnexoSelector)
                <div class="fx-2">
                    <label class="fx-lbl" for="anexo_id">Anexo</label>
                    <select class="fx-in" id="anexo_id" name="anexo_id">
                        <option value="">Selecciona</option>
                        @foreach ($anexos as $anexoItem)
                            <option value="{{ $anexoItem->id }}" @selected((string) old('anexo_id', $selectedAnexoId ?? $registro->anexo_id ?? '') === (string) $anexoItem->id)>
                                #{{ $anexoItem->id }} - {{ $anexoItem->titulo ?: 'Sin título' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="anexo_id" value="{{ old('anexo_id', $selectedAnexoId ?? $registro->anexo_id ?? $anexos->first()?->id) }}">
                <div class="fx-2 fx-auto">
                    <strong>Anexo aplicado automáticamente</strong>
                    {{ $selectedAnexo?->titulo ?: 'Anexo único' }}
                </div>
            @endif
            <div>
                <label class="fx-lbl" for="item">{{ config('anexo.column_labels.item') }}</label>
                <input class="fx-in" type="number" min="1" id="item" name="item" value="{{ old('item', $registro->item ?? $nextItemPreview ?? '') }}" placeholder="Vacío = automático">
            </div>
            <div>
                <label class="fx-lbl" for="codigo_unidad">{{ config('anexo.column_labels.codigo_unidad') }}</label>
                <input class="fx-in" type="text" id="codigo_unidad" name="codigo_unidad" value="{{ old('codigo_unidad', $registro->codigo_unidad ?? '') }}">
            </div>
            <div class="fx-2">
                <label class="fx-lbl" for="expediente_siged">{{ config('anexo.column_labels.expediente_siged') }}</label>
                <input class="fx-in" type="text" id="expediente_siged" name="expediente_siged" value="{{ old('expediente_siged', $registro->expediente_siged ?? '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="fecha_asignacion">{{ config('anexo.column_labels.fecha_asignacion') }}</label>
                <input class="fx-in" type="date" id="fecha_asignacion" name="fecha_asignacion" value="{{ old('fecha_asignacion', isset($registro) && $registro->fecha_asignacion ? $registro->fecha_asignacion->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="numero_documento">{{ config('anexo.column_labels.numero_documento') }}</label>
                <input class="fx-in" type="text" id="numero_documento" name="numero_documento" value="{{ old('numero_documento', $registro->numero_documento ?? '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="codigo_osinergmin">{{ config('anexo.column_labels.codigo_osinergmin') }}</label>
                <input class="fx-in" type="text" id="codigo_osinergmin" name="codigo_osinergmin" value="{{ old('codigo_osinergmin', $registro->codigo_osinergmin ?? '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="codigo_actividad">{{ config('anexo.column_labels.codigo_actividad') }}</label>
                <input class="fx-in" type="text" id="codigo_actividad" name="codigo_actividad" value="{{ old('codigo_actividad', $registro->codigo_actividad ?? '') }}">
            </div>
        </div>
    </section>

    <section class="fx-card">
        <div class="fx-head">
            <div class="fx-ico"><i class="ti ti-building-store"></i></div>
            <div><h3>Datos del agente</h3></div>
        </div>

        <div class="fx-grid">
            <div class="fx-2">
                <label class="fx-lbl" for="razon_social_agente">{{ config('anexo.column_labels.razon_social_agente') }}</label>
                <input class="fx-in" type="text" id="razon_social_agente" name="razon_social_agente" value="{{ old('razon_social_agente', $registro->razon_social_agente ?? '') }}">
            </div>
            <div class="fx-2">
                <label class="fx-lbl" for="personal_es">{{ config('anexo.column_labels.personal_es') }}</label>
                <input class="fx-in" type="text" id="personal_es" name="personal_es" value="{{ old('personal_es', $registro->personal_es ?? '') }}">
            </div>
        </div>
    </section>

    <section class="fx-card">
        <div class="fx-head">
            <div class="fx-ico"><i class="ti ti-shield-check"></i></div>
            <div><h3>Supervisión/Fiscalización</h3></div>
        </div>

        <div class="fx-grid">
            <div class="fx-2">
                <label class="fx-lbl" for="tipo_supervision">{{ config('anexo.column_labels.tipo_supervision') }}</label>
                <input class="fx-in" type="text" id="tipo_supervision" name="tipo_supervision" value="{{ old('tipo_supervision', $registro->tipo_supervision ?? '') }}">
            </div>
            <div class="fx-2">
                <label class="fx-lbl" for="tipo_entregable">{{ config('anexo.column_labels.tipo_entregable') }}</label>
                <input class="fx-in" type="text" id="tipo_entregable" name="tipo_entregable" value="{{ old('tipo_entregable', $registro->tipo_entregable ?? '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="numero_informe">{{ config('anexo.column_labels.numero_informe') }}</label>
                <input class="fx-in" type="text" id="numero_informe" name="numero_informe" value="{{ old('numero_informe', $registro->numero_informe ?? '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="visitado">{{ config('anexo.column_labels.visitado') }}</label>
                <select class="fx-in" id="visitado" name="visitado">
                    <option value="1" @selected((string) old('visitado', isset($registro) ? (int) $registro->visitado : '0') === '1')>Sí</option>
                    <option value="0" @selected((string) old('visitado', isset($registro) ? (int) $registro->visitado : '0') === '0')>No</option>
                </select>
            </div>
            <div>
                <label class="fx-lbl" for="efectividad">{{ config('anexo.column_labels.efectividad') }}</label>
                <select class="fx-in" id="efectividad" name="efectividad">
                    <option value="1" @selected((string) old('efectividad', isset($registro) ? (int) $registro->efectividad : '0') === '1')>Sí</option>
                    <option value="0" @selected((string) old('efectividad', isset($registro) ? (int) $registro->efectividad : '0') === '0')>No</option>
                </select>
            </div>
        </div>
    </section>

    <section class="fx-card">
        <div class="fx-head">
            <div class="fx-ico"><i class="ti ti-calendar-event"></i></div>
            <div><h3>Fechas y estado</h3></div>
        </div>

        <div class="fx-grid">
            <div>
                <label class="fx-lbl" for="fecha_visita">{{ config('anexo.column_labels.fecha_visita') }}</label>
                <input class="fx-in" type="date" id="fecha_visita" name="fecha_visita" value="{{ old('fecha_visita', isset($registro) && $registro->fecha_visita ? $registro->fecha_visita->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="fx-lbl" for="fecha_derivacion">{{ config('anexo.column_labels.fecha_derivacion') }}</label>
                <input class="fx-in" type="date" id="fecha_derivacion" name="fecha_derivacion" value="{{ old('fecha_derivacion', isset($registro) && $registro->fecha_derivacion ? $registro->fecha_derivacion->format('Y-m-d') : '') }}">
            </div>
            <div class="fx-2">
                <label class="fx-lbl" for="estado_entregable">{{ config('anexo.column_labels.estado_entregable') }}</label>
                <select class="fx-in" id="estado_entregable" name="estado_entregable">
                    <option value="">Selecciona</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}" @selected(old('estado_entregable', $registro->estado_entregable ?? 'EN PROCESO') === $estado)>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    <section class="fx-card">
        <div class="fx-head">
            <div class="fx-ico"><i class="ti ti-notes"></i></div>
            <div>
                <h3>Observaciones</h3>
                @if ($selectedAnexo)
                    <p>Trabajando sobre {{ $selectedAnexo->titulo }}.</p>
                @endif
            </div>
        </div>

        <div class="fx-grid">
            <div class="fx-2">
                <label class="fx-lbl" for="observaciones">{{ config('anexo.column_labels.observaciones') }}</label>
                <textarea class="fx-in" id="observaciones" name="observaciones" rows="5">{{ old('observaciones', $registro->observaciones ?? '') }}</textarea>
            </div>
            <div class="fx-2">
                <label class="fx-lbl" for="comentarios">{{ config('anexo.column_labels.comentarios') }}</label>
                <textarea class="fx-in" id="comentarios" name="comentarios" rows="5">{{ old('comentarios', $registro->comentarios ?? '') }}</textarea>
            </div>
        </div>
    </section>

    <div class="fx-actions">
        <a href="{{ $editing ? route('registros.show', $registro) : route('registros.index') }}" class="fx-btn"><i class="ti ti-arrow-left"></i>Volver</a>
        <button type="submit" class="fx-btn fx-main"><i class="ti ti-device-floppy"></i>{{ $editing ? 'Actualizar registro' : 'Guardar registro' }}</button>
    </div>
</div>
