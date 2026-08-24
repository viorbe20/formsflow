<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/scss/app.scss',
        'resources/js/app.js',
    ])

    <title>FormsFlow — Demo</title>
</head>

<body class="home-page">

    <main class="home-container">

        <section class="home-hero">

            <span class="home-brand">FORMSFLOW</span>

            <h1>Demo de gestión de solicitudes</h1>

            <p class="home-description">
                Aplicación web demostradora desarrollada con Laravel
                para la gestión de solicitudes, integración de datos,
                automatización de procesos y explotación de información.
            </p>

            <div class="home-actions">

                <a href="{{ route('application-requests.create') }}"
                   class="home-button home-button-primary">
                    Nueva solicitud
                </a>

                <a href="{{ route('dashboard') }}"
                   class="home-button home-button-secondary">
                    Dashboard
                </a>

            </div>

        </section>

        <section class="home-technologies">

            <h2>Componentes demostrados</h2>

            <div class="home-tags">
                <span>Laravel</span>
                <span>PostgreSQL</span>
                <span>API REST</span>
                <span>ETL</span>
                <span>PLN</span>
                <span>Docker</span>
            </div>

            <p class="home-author">
                Proyecto desarrollado por <strong>Virginia Ordoño Bernier (2026)</strong>
            </p>

        </section>

    </main>

</body>
</html>