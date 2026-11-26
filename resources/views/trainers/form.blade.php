@if ($errors->any())
    <div class="alert alert-danger text-white">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group mb-3">
    {{ Form::label('name', 'Nombre:') }}
    {{ Form::text('name', $trainer->name ?? null, ['class' => 'form-control', 'required' => true]) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('apellido', 'Apellido:') }}
    {{ Form::text('apellido', $trainer->apellido ?? null, ['class' => 'form-control', 'required' => true]) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('avatar', 'Foto (avatar):') }}
    {{ Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar', 'accept' => 'image/*']) }}
    <small class="text-muted">JPG, PNG, GIF o WEBP. Máximo 2 MB.</small>
</div>

@php $currentAvatar = isset($trainer) ? $trainer->avatar_url : null; @endphp
<div class="mb-4 text-center">
    <img id="avatar-preview"
         src="{{ $currentAvatar }}"
         alt="Vista previa"
         class="rounded-circle {{ $currentAvatar ? '' : 'd-none' }}"
         style="width: 120px; height: 120px; object-fit: cover; background-color: #EFEFEF;">
</div>

@push('scripts')
<script>
    document.getElementById('avatar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('avatar-preview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    });
</script>
@endpush