@extends('layouts.app')
@section('title', 'Nuevo Trainer')

@section('content')
<div class="container mt-4" style="max-width: 640px;">
    <h3 class="mb-4">Nuevo Trainer</h3>

    {!! Form::open(['route' => 'trainers.store', 'method' => 'POST', 'files' => true]) !!}
        @include('trainers.form')
        <div class="d-flex gap-2">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('trainers.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    {!! Form::close() !!}
</div>
@endsection