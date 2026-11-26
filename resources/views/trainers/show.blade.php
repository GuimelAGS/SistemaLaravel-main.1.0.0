@extends('layouts.app')
@section('title', 'Detalles del Trainer')

@section('content')
<div class="container mt-4" style="max-width: 720px;">

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('trainers.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <a href="{{ route('trainers.edit', $trainer) }}" class="btn btn-primary btn-sm">Editar</a>
        <a href="{{ route('trainers.pdf', $trainer->id) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Descargar ficha PDF
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body text-center">
            <div class="mb-3">@include('trainers._avatar', ['trainer' => $trainer, 'size' => 140])</div>
            <h4 class="mb-4">{{ $trainer->name }} {{ $trainer->apellido }}</h4>

            <table class="table text-start mb-0">
                <tbody>
                    <tr><th style="width: 35%;">ID</th><td>{{ $trainer->id }}</td></tr>
                    <tr><th>Nombre</th><td>{{ $trainer->name }}</td></tr>
                    <tr><th>Apellido</th><td>{{ $trainer->apellido }}</td></tr>
                    <tr><th>Slug</th><td>{{ $trainer->slug }}</td></tr>
                    <tr><th>Archivo de avatar</th><td>{{ $trainer->avatar ?? 'Sin avatar' }}</td></tr>
                    <tr><th>Creado</th><td>{{ optional($trainer->created_at)->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Actualizado</th><td>{{ optional($trainer->updated_at)->format('d/m/Y H:i') }}</td></tr>
                </tbody>
            </table>

            <form action="{{ route('trainers.destroy', $trainer) }}" method="POST" class="mt-4"
                  onsubmit="return confirm('¿Mover a la papelera?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning btn-sm">Mover a la papelera</button>
            </form>
        </div>
    </div>
</div>
@endsection