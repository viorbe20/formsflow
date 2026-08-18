<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/js/app.js')

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
                @error('name')
                    aria-invalid="true"
                    aria-describedby="name-error"
                @enderror
                required
            >

            @error('name')
                <p id="name-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email">Correo electrónico</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                @error('email')
                    aria-invalid="true"
                    aria-describedby="email-error"
                @enderror
                required
            >

            @error('email')
                <p id="email-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone">Teléfono</label>

            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                @error('phone')
                    aria-invalid="true"
                    aria-describedby="phone-error"
                @enderror
            >

            @error('phone')
                <p id="phone-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="organization">Consejería</label>

            <select
                id="organization"
                name="organization"
                @error('organization')
                    aria-invalid="true"
                    aria-describedby="organization-error"
                @enderror
                required
            >
                <option value="">Seleccione una Consejería</option>

                <option value="Economía, Hacienda y Fondos Europeos"
                    {{ old('organization') === 'Economía, Hacienda y Fondos Europeos' ? 'selected' : '' }}>
                    Economía, Hacienda y Fondos Europeos
                </option>

                <option value="Educación"
                    {{ old('organization') === 'Educación' ? 'selected' : '' }}>
                    Educación
                </option>

                <option value="IA, Desarrollo Digital y Administración Pública"
                    {{ old('organization') === 'IA, Desarrollo Digital y Administración Pública' ? 'selected' : '' }}>
                    IA, Desarrollo Digital y Administración Pública
                </option>

                <option value="Presidencia, Sanidad y Emergencias"
                    {{ old('organization') === 'Presidencia, Sanidad y Emergencias' ? 'selected' : '' }}>
                    Presidencia, Sanidad y Emergencias
                </option>
            </select>

            @error('organization')
                <p id="organization-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="unit">Unidad destinataria</label>

            <select
                id="unit"
                name="unit"
                data-old="{{ old('unit') }}"
                @error('unit')
                    aria-invalid="true"
                    aria-describedby="unit-error"
                @enderror
                required
            >
                <option value="">Seleccione primero una Consejería</option>
            </select>

            @error('unit')
                <p id="unit-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
    <label for="subject">Asunto</label>

    <select
        id="subject"
        name="subject"
        @error('subject')
            aria-invalid="true"
            aria-describedby="subject-error"
        @enderror
        required
    >
        <option value="">Seleccione un asunto</option>

        <option value="Información sobre un procedimiento"
            {{ old('subject') === 'Información sobre un procedimiento' ? 'selected' : '' }}>
            Información sobre un procedimiento
        </option>

        <option value="Problema con un servicio"
            {{ old('subject') === 'Problema con un servicio' ? 'selected' : '' }}>
            Problema con un servicio
        </option>

        <option value="Solicitud de documentación"
            {{ old('subject') === 'Solicitud de documentación' ? 'selected' : '' }}>
            Solicitud de documentación
        </option>

        <option value="Otros"
            {{ old('subject') === 'Otros' ? 'selected' : '' }}>
            Otros
        </option>
    </select>

    @error('subject')
        <p id="subject-error">{{ $message }}</p>
    @enderror
</div>

        <div>
            <label for="statement">Expone</label>

            <textarea
                id="statement"
                name="statement"
                @error('statement')
                    aria-invalid="true"
                    aria-describedby="statement-error"
                @enderror
                required
            >{{ old('statement') }}</textarea>

            @error('statement')
                <p id="statement-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="request_text">Solicita</label>

            <textarea
                id="request_text"
                name="request_text"
                @error('request_text')
                    aria-invalid="true"
                    aria-describedby="request-text-error"
                @enderror
                required
            >{{ old('request_text') }}</textarea>

            @error('request_text')
                <p id="request-text-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Enviar solicitud</button>

    </form>

</body>
</html>