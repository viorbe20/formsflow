<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva solicitud</title>
</head>
<body>

    <h1>Nueva solicitud</h1>

    @if (session('success'))
    <div>
        <h2>{{ session('success') }}</h2>

        <p>
            Código de referencia:
            <strong>{{ session('reference_code') }}</strong>
        </p>
    </div>
    @endif

    @if ($errors->any())
        <div>
            <strong>Se han producido los siguientes errores:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('application-requests.store') }}">

        @csrf

        <div>
            <label for="name">Nombre</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="phone">Teléfono</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
            >
        </div>

        <div>
            <label for="organization">Organismo</label>
            <input
                type="text"
                id="organization"
                name="organization"
                value="{{ old('organization') }}"
                required
            >
        </div>

        <div>
            <label for="unit">Unidad</label>
            <input
                type="text"
                id="unit"
                name="unit"
                value="{{ old('unit') }}"
                required
            >
        </div>

        <div>
            <label for="subject">Asunto</label>
            <input
                type="text"
                id="subject"
                name="subject"
                value="{{ old('subject') }}"
                required
            >
        </div>

        <div>
            <label for="statement">Expone</label>
            <textarea
                id="statement"
                name="statement"
                required
            >{{ old('statement') }}</textarea>
        </div>

        <div>
            <label for="request_text">Solicita</label>
            <textarea
                id="request_text"
                name="request_text"
                required
            >{{ old('request_text') }}</textarea>
        </div>

        <button type="submit">Enviar solicitud</button>

    </form>

</body>
</html>