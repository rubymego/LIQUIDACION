@extends('layouts.app')

@section('title', 'Configuración del Anexo | SANTRIX ANEXO LOCAL')
@section('page-title', 'Configuración del Anexo')

@push('styles')
<style>
    .ax-hero { background: linear-gradient(135deg, #10243b 0%, #1675b9 100%); color: #fff; border-radius: 16px; padding: 26px 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 18px; flex-wrap: wrap; }
    .ax-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2px; color: #9fd8ea; text-transform: uppercase; }
    .ax-hero h2 { font-size: 22px; font-weight: 800; margin: 8px 0 4px; line-height: 1.3; }
    .ax-hero p { margin: 0; color: #cfe3f1; font-size: 14px; max-width: 560px; }
    .ax-btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 18px; border-radius: 9px; font-size: 13.5px; font-weight: 600; text-decoration: none; background: #fff; color: var(--blue); border: 1px solid #fff; transition: background .2s; }
    .ax-btn:hover { background: #eef4fa; }

    .ax-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px; }
    .ax-info-item { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; }
    .ax-ico { width: 42px; height: 42px; border-radius: 11px; background: #e8f2fa; color: var(--blue); display: grid; place-items: center; font-size: 21px; flex-shrink: 0; }
    .ax-lbl { font-size: 12px; color: var(--muted); }
    .ax-val { font-size: 14.5px; font-weight: 700; margin-top: 2px; word-break: break-word; }

    .ax-panel { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px #19365208; }
    .ax-panel-head { margin-bottom: 16px; }
    .ax-panel-head h3 { margin: 0; font-size: 16px; font-weight: 700; }
    .ax-panel-head p { margin: 4px 0 0; font-size: 13px; color: var(--muted); }
    .ax-table-wrap { overflow-x: auto; }
    .ax-table td { vertical-align: middle; }
    .ax-strong { font-weight: 700; }
    .ax-pill { display: inline-block; background: #e3f0fb; color: #0e5a96; border-radius: 20px; padding: 3px 12px; font-size: 12.5px; font-weight: 700; }

    .ax-acts { display: flex; gap: 6px; align-items: center; }
    .ax-act { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #dce3eb; background: #fff; color: #4a5b70; font-size: 17px; cursor: pointer; text-decoration: none; transition: all .15s; }
    .ax-act:hover { background: #eef4fa; color: var(--blue); border-color: #b9d3ea; }
    .ax-act.ax-del:hover { background: #fdecea; color: #c0392b; border-color: #f2b8b2; }
    .ax-acts form { margin: 0; }

    .ax-empty { text-align: center; padding: 50px 20px; color: var(--muted); }
    .ax-empty i { font-size: 44px; color: #b8c5d3; }
    .ax-empty strong { display: block; color: var(--text); font-size: 17px; margin: 10px 0 4px; }
    .ax-pager { margin-top: 20px; }
</style>
@endpush

@section('content')
    @php($pdfDisponible = class_exists(\Barryvdh\DomPDF\Facade\Pdf::class))

    <section class="ax-hero">
        <div>
            <div class="ax-eyebrow">Configuración del anexo</div>
            <h2>{{ $configuracion?->empresa ?: config('anexo.base_entregable.empresa_supervisora') }}</h2>
            <p>La empresa es única y fija. Aquí administras cada anexo que luego exportas por separado.</p>
        </div>
        <a href="{{ route('anexos.create') }}" class="ax-btn"><i class="ti ti-plus"></i>Nuevo anexo</a>
    </section>

    <div class="ax-info">
        <div class="ax-info-item">
            <div class="ax-ico"><i class="ti ti-id"></i></div>
            <div>
                <div class="ax-lbl">{{ config('anexo.entregable_labels.ruc') }}</div>
                <div class="ax-val">{{ $configuracion?->ruc ?: config('anexo.base_entregable.ruc') }}</div>
            </div>
        </div>
        <div class="ax-info-item">
            <div class="ax-ico"><i class="ti ti-file-text"></i></div>
            <div>
                <div class="ax-lbl">{{ config('anexo.entregable_labels.numero_contrato') }}</div>
                <div class="ax-val">{{ $configuracion?->contrato ?: config('anexo.base_entregable.numero_contrato') }}</div>
            </div>
        </div>
        <div class="ax-info-item">
            <div class="ax-ico"><i class="ti ti-briefcase"></i></div>
            <div>
                <div class="ax-lbl">{{ config('anexo.entregable_labels.nombre_servicio') }}</div>
                <div class="ax-val">{{ $configuracion?->nombre_servicio_contratado ?: config('anexo.base_entregable.nombre_servicio') }}</div>
            </div>
        </div>
    </div>

    <section class="ax-panel">
        <div class="ax-panel-head">
            <h3>Anexos registrados</h3>
            <p>Cada anexo se exporta por separado para no mezclar registros.</p>
        </div>

        @if ($anexos->isEmpty())
            <div class="ax-empty">
                <i class="ti ti-inbox"></i>
                <strong>No hay anexos registrados</strong>
                <span>Crea el primer anexo para empezar a registrar filas y exportarlo por separado.</span>
            </div>
        @else
            <div class="ax-table-wrap">
                <table class="ax-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>{{ config('anexo.entregable_labels.periodo') }}</th>
                            <th>{{ config('anexo.entregable_labels.fecha_ingreso_entregable') }}</th>
                            <th>Estado</th>
                            <th>Filas registradas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anexos as $anexo)
                            <tr>
                                <td class="ax-strong">#{{ $anexo->id }}</td>
                                <td class="ax-strong">{{ $anexo->titulo }}</td>
                                <td>{{ $anexo->periodo_ejecucion_contractual ?: 'Sin dato' }}</td>
                                <td>{{ $anexo->fecha_contractual_ingreso_entregable?->format('d/m/Y') ?: 'Sin dato' }}</td>
                                <td><x-status-badge :value="$anexo->estado" /></td>
                                <td><span class="ax-pill">{{ $anexo->registros_count }}</span></td>
                                <td>
                                    <div class="ax-acts">
                                        <a href="{{ route('anexos.show', $anexo) }}" class="ax-act" title="Ver"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('anexos.edit', $anexo) }}" class="ax-act" title="Editar"><i class="ti ti-pencil"></i></a>
                                        <a href="{{ route('anexos.exportar.excel', $anexo) }}" class="ax-act" title="Exportar Excel"><i class="ti ti-file-spreadsheet"></i></a>
                                        @if ($pdfDisponible)
                                            <a href="{{ route('anexos.exportar.pdf', $anexo) }}" class="ax-act" title="Exportar PDF"><i class="ti ti-file-type-pdf"></i></a>
                                        @endif
                                        <form action="{{ route('anexos.destroy', $anexo) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este anexo y todos sus registros?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ax-act ax-del" title="Eliminar"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="ax-pager">
                {{ $anexos->links() }}
            </div>
        @endif
    </section>
@endsection
