@extends('layouts.app')
@section('title', 'Trainers')

@section('content')
<div class="container mt-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h3 class="m-0">Listado de Trainers <small class="text-muted fs-6">({{ $trainers->count() }})</small></h3>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('trainers.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Nuevo Trainer
            </a>
            <a href="{{ route('trainers.pdf.all') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
            </a>
            <a href="{{ route('trainers.excel') }}" class="btn btn-info btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Descargar Excel
            </a>
        </div>
    </div>

    <form action="{{ route('trainers.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" autocomplete="off"
                   placeholder="Buscar por nombre o apellido..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
            @if(request('search'))
                <a href="{{ route('trainers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            @endif
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Slug</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trainers as $trainer)
                        <tr>
                            <td>@include('trainers._avatar', ['trainer' => $trainer, 'size' => 48])</td>
                            <td>{{ $trainer->id }}</td>
                            <td class="fw-bold">{{ $trainer->name }}</td>
                            <td>{{ $trainer->apellido }}</td>
                            <td class="text-muted">{{ $trainer->slug }}</td>
                            <td>{{ optional($trainer->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ optional($trainer->updated_at)->format('d/m/Y H:i') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('trainers.show', $trainer) }}" class="btn btn-secondary btn-sm">Ver</a>
                                <a href="{{ route('trainers.edit', $trainer) }}" class="btn btn-primary btn-sm">Editar</a>

                                <form action="{{ route('trainers.destroy', $trainer) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Mover a {{ e($trainer->name) }} a la papelera?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning btn-sm">Papelera</button>
                                </form>

                                <form action="{{ route('trainers.force-destroy', $trainer->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿ELIMINAR PERMANENTEMENTE a {{ e($trainer->name) }}? No se puede deshacer y borra también su foto.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                No hay trainers registrados.
                                <a href="{{ route('trainers.create') }}">Crea el primero</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection