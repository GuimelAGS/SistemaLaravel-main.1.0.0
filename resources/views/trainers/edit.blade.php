@extends('layouts.app')
@section('title', 'Editar Trainer')

@section('content')
<div class="container mt-4" style="max-width: 640px;">
    <h3 class="mb-4">Editar Trainer</h3>

    {!! Form::model($trainer, ['route' => ['trainers.update', $trainer], 'method' => 'PUT', 'files' => true]) !!}
        @include('trainers.form')
        <div class="d-flex gap-2">
            {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('trainers.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    {!! Form::close() !!}
</div>
@endsection