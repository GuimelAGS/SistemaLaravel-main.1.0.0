<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($trainers) ? 'Listado de Trainers' : 'Ficha de Trainer' }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #333; margin: 30px; font-size: 12px; }
        .header { text-align: center; border-bottom: 3px solid #004d99; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #004d99; margin: 0; font-size: 24px; }
        .info { font-size: 11px; text-align: right; margin-bottom: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px 10px; text-align: left; }
        th { background-color: #e6f2ff; color: #004d99; }
        tr:nth-child(even) td { background-color: #f9f9f9; }
        .center { text-align: center; }
        .avatar-small { height: 45px; }
        .avatar-big { height: 150px; }
        .card { border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: 0 auto; }
        .card h2 { text-align: center; color: #004d99; margin-top: 0; }
        .label { width: 35%; font-weight: bold; background-color: #e6f2ff; }
    </style>
</head>
<body>

@if (isset($trainers))

    <div class="header"><h1>Listado de Trainers</h1></div>
    <div class="info">Total: {{ $trainers->count() }} | Generado el: {{ date('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="center">Foto</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Slug</th>
                <th>Creado</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainers as $i => $trainer)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td class="center">
                        @if ($trainer->avatar && is_file(public_path('images/' . $trainer->avatar)))
                            <img src="{{ public_path('images/' . $trainer->avatar) }}" class="avatar-small">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $trainer->id }}</td>
                    <td>{{ $trainer->name }}</td>
                    <td>{{ $trainer->apellido }}</td>
                    <td>{{ $trainer->slug }}</td>
                    <td>{{ optional($trainer->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ optional($trainer->updated_at)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else

    <div class="header"><h1>Ficha del Trainer</h1></div>

    <div class="card">
        <h2>{{ $trainer->name }} {{ $trainer->apellido }}</h2>

        @if ($trainer->avatar && is_file(public_path('images/' . $trainer->avatar)))
            <div class="center" style="margin-bottom: 15px;">
                <img src="{{ public_path('images/' . $trainer->avatar) }}" class="avatar-big">
            </div>
        @endif

        <table>
            <tr><td class="label">ID</td><td>{{ $trainer->id }}</td></tr>
            <tr><td class="label">Nombre</td><td>{{ $trainer->name }}</td></tr>
            <tr><td class="label">Apellido</td><td>{{ $trainer->apellido }}</td></tr>
            <tr><td class="label">Slug</td><td>{{ $trainer->slug }}</td></tr>
            <tr><td class="label">Archivo de avatar</td><td>{{ $trainer->avatar ?? 'Sin avatar' }}</td></tr>
            <tr><td class="label">Creado</td><td>{{ optional($trainer->created_at)->format('d/m/Y H:i') }}</td></tr>
            <tr><td class="label">Actualizado</td><td>{{ optional($trainer->updated_at)->format('d/m/Y H:i') }}</td></tr>
        </table>

        <div class="info center" style="margin-top: 15px;">Generado el: {{ date('d/m/Y H:i') }}</div>
    </div>

@endif

</body>
</html>