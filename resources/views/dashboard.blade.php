<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    {{-- Define the viewport for responsive layouts. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FormsFlow - Dashboard</title>

    @vite([
    'resources/scss/app.scss',
    'resources/js/app.js'
    ])

</head>

<body class="dashboard-page">

    {{-- Main Dashboard container. --}}
    <main class="dashboard-container">

        {{-- Dashboard header. --}}
        <header class="dashboard-header">

            <div>
                <span class="dashboard-brand">FORMSFLOW</span>
                <h1>Dashboard</h1>
            </div>

            <a href="{{ route('application-requests.create') }}" class="btn btn-primary">
                + Nueva solicitud
            </a>

        </header>


        {{-- Main Dashboard content. --}}
        <section class="dashboard-content">

            {{-- Main request indicators. --}}
            <div class="dashboard-stats">

                <article class="stat-card">

                    <span class="stat-label">
                        Total
                    </span>

                    <strong class="stat-value">
                        {{ $totalRequests }}
                    </strong>

                </article>


                <article class="stat-card stat-pending">

                    <span class="stat-label">
                        Pendientes
                    </span>

                    <strong class="stat-value">
                        {{ $pendingRequests }}
                    </strong>

                </article>


                <article class="stat-card stat-archived">

                    <span class="stat-label">
                        Archivadas
                    </span>

                    <strong class="stat-value">
                        {{ $archivedRequests }}
                    </strong>

                </article>

            </div>


            {{-- Requests grouped by organization. --}}
            <section class="dashboard-section">

                <div class="section-header">
                    <h2>Solicitudes por organización</h2>
                </div>

            @if ($requestsByOrganization->isNotEmpty())

                <div class="organization-list">

                    {{-- Get the highest number of requests to calculate relative bar widths. --}}
                    @php
                        $maxOrganizationTotal = $requestsByOrganization->max('total');
                    @endphp

                    @foreach ($requestsByOrganization as $organization)

                        <div class="organization-row">

                            <div class="organization-info">

                                <span class="organization-name">
                                    {{ $organization->organization }}
                                </span>

                               <strong class="organization-total">
                                    {{ $organization->total }}
                                    ({{ number_format($organization->percentage, 1, ',', '.') }}%)
                                </strong>

                            </div>

                            {{-- Display a proportional bar based on the highest organization total. --}}
                            <div class="organization-bar-container">

                                <div
                                    class="organization-bar"
                                    style="width: {{ ($organization->total / $maxOrganizationTotal) * 100 }}%;"
                                ></div>

                            </div>

                        </div>

                    @endforeach

                    </div>

                @else

                    <p class="empty-message">
                        No hay datos disponibles.
                    </p>

                @endif

            </section>


            {{-- Most recent processed requests. --}}
            <section class="dashboard-section" id="requests">

                <div class="section-header request-section-header">

                    <h2>Últimas solicitudes</h2>

                        <form
                            method="GET"
                            action="{{ route('dashboard') }}"
                            class="request-search"
                        >
                            <input
                                type="text"
                                id="reference"
                                name="reference"
                                value="{{ request('reference') }}"
                                placeholder="Buscar por referencia"
                                aria-label="Buscar solicitud por referencia"
                            >

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Buscar
                            </button>

                            <button
                                type="button"
                                class="btn btn-secondary dashboard-history-button"
                                disabled
                                title="Consulta histórica por rango de fechas — Próximamente"
                            >
                                Historial de solicitudes
                            </button>

                            @if (request('reference'))
                                <a
                                    href="{{ route('dashboard') }}#requests"
                                    class="btn btn-secondary"
                                >
                                    Limpiar
                                </a>
                            @endif
                        </form>
                </div>

                @if ($recentRequests->isNotEmpty())

                    <div class="table-container">

                        <table class="requests-table">

                <thead>
                    <tr>

                        <th>Referencia</th>

                        <th>Organización</th>

                        <th>Asunto</th>

                        <th>Estado</th>

                        <th>Categoría</th>

                        <th>Prioridad</th>

                        <th>Fecha</th>

                        <th>Acción</th>

                    </tr>
                </thead>


                            <tbody>

                                @foreach ($recentRequests as $request)

                                    <tr>

                                        {{-- Display the unique reference of the processed request. --}}
                                        <td class="request-reference">
                                            {{ $request->reference_code }}
                                        </td>


                                        {{-- Display the organization associated with the request. --}}
                                        <td>
                                            {{ $request->organization }}
                                        </td>


                                        {{-- Display the request subject. --}}
                                        <td>
                                            {{ $request->subject }}
                                        </td>


                                        {{-- Display a human-readable label for the request status. --}}
                                        <td>

                                            @if ($request->status === 'pending')

                                                <span class="status-badge status-pending">
                                                    Pendiente
                                                </span>

                                            @elseif ($request->status === 'archived')

                                                <span class="status-badge status-archived">
                                                    Archivada
                                                </span>

                                            @else

                                                <span class="status-badge">
                                                    {{ ucfirst($request->status) }}
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Display the NLP classification category. --}}
                                        <td>

                                            @if ($request->category === 'informacion')

                                                <span class="nlp-badge nlp-category">
                                                    Información
                                                </span>

                                            @elseif ($request->category === 'incidencia')

                                                <span class="nlp-badge nlp-category">
                                                    Incidencia
                                                </span>

                                            @elseif ($request->category === 'documentacion')

                                                <span class="nlp-badge nlp-category">
                                                    Documentación
                                                </span>

                                            @else

                                                <span class="nlp-badge">
                                                    —
                                                </span>

                                            @endif

                                        </td>


                                    {{-- Display the NLP priority level. --}}
                                    <td>

                                        @if ($request->priority === 'baja')

                                            <span class="nlp-badge priority-low">
                                                Baja
                                            </span>

                                        @elseif ($request->priority === 'media')

                                            <span class="nlp-badge priority-medium">
                                                Media
                                            </span>

                                        @elseif ($request->priority === 'alta')

                                            <span class="nlp-badge priority-high">
                                                Alta
                                            </span>

                                        @else

                                            <span class="nlp-badge">
                                                —
                                            </span>

                                        @endif

                                    </td>
                                        {{-- Display the date and time when the request was processed. --}}
                                        <td class="request-date">

                                            {{ \Illuminate\Support\Carbon::parse($request->processed_at)->format('d/m/Y H:i') }}

                                        </td>


                                        {{-- The request detail modal will be implemented later. --}}
                                        <td>

                                            <button
                                                type="button"
                                                class="btn btn-secondary request-detail-button"
                                                data-reference="{{ $request->reference_code }}"
                                                data-organization="{{ $request->organization }}"
                                                data-unit="{{ $request->unit }}"
                                                data-subject="{{ $request->subject }}"
                                                data-status="{{ $request->status }}"
                                                data-category="{{ $request->category ?? '' }}"
                                                data-priority="{{ $request->priority ?? '' }}"
                                                data-text="{{ $request->normalized_text }}"
                                                data-processed-at="{{ \Illuminate\Support\Carbon::parse($request->processed_at)->format('d/m/Y H:i') }}"
                                            >
                                                Ver
                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Display pagination controls for the server-side paginated results. --}}
                    <div class="pagination-container">

                        {{-- Keep the user positioned at the requests section when changing pages. --}}
                        {{ $recentRequests->fragment('requests')->links() }}

                    </div>

                @else

                    <p class="empty-message">
                        No hay solicitudes disponibles.
                    </p>

                @endif

            </section>


            {{-- Information about the latest generated report. --}}
            <section class="report-footer">

                <span>
                    Último informe generado:
                </span>

                @if ($latestReport)

                    <strong>
                        {{ $latestReport->generated_at->format('d/m/Y H:i') }}
                    </strong>

                @else

                    <strong>
                        No hay informes disponibles.
                    </strong>

                @endif

            </section>

        </section>

            {{-- Request detail modal. --}}
            <div
                id="request-detail-modal"
                class="request-modal"
                aria-hidden="true"
            >
                <div
                    class="request-modal-content"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="request-modal-title"
                >

                    <div class="request-modal-header">

                        <h2 id="request-modal-title">
                            Detalle de la solicitud
                        </h2>

                        <button
                            type="button"
                            class="request-modal-close"
                            aria-label="Cerrar"
                        >
                            ×
                        </button>

                    </div>


                    <div class="request-modal-body">

                        <div class="request-detail-grid">

                            <div>
                                <span>Referencia</span>
                                <strong id="modal-reference" class="request-modal-reference"></strong>
                            </div>

                            <div>
                                <span>Organización</span>
                                <strong id="modal-organization"></strong>
                            </div>

                            <div>
                                <span>Unidad</span>
                                <strong id="modal-unit"></strong>
                            </div>

                            <div>
                                <span>Estado</span>
                                <strong id="modal-status"></strong>
                            </div>

                            <div>
                                <span>Categoría</span>
                                <strong id="modal-category"></strong>
                            </div>

                            <div>
                                <span>Prioridad</span>
                                <strong id="modal-priority"></strong>
                            </div>

                            <div>
                                <span>Fecha de registro</span>
                                <strong id="modal-processed-at"></strong>
                            </div>

                        </div>


                        <div class="request-detail-full">

                            <span>Asunto</span>
                            <p id="modal-subject"></p>

                        </div>


                        <div class="request-detail-full">

                            <span>Descripción de la solicitud</span>
                            <p id="modal-text"></p>

                        </div>

                    </div>


                </div>
            </div>
    </main>

</body>
</html>
