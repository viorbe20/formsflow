<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    {{-- Define the viewport for responsive layouts. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FormsFlow - Dashboard</title>

    @vite(['resources/scss/app.scss'])
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

            <a href="#" class="btn btn-primary">
                + Nueva solicitud
            </a>
        </header>


        {{-- Main Dashboard content. --}}
        <section class="dashboard-content">

            {{-- Main request indicators. --}}
            <div class="dashboard-stats">

                <article class="stat-card">
                    <span class="stat-label">Total</span>

                    <strong class="stat-value">
                        {{ $latestReport?->total_requests ?? 0 }}
                    </strong>
                </article>


                <article class="stat-card stat-pending">
                    <span class="stat-label">Pendientes</span>

                    <strong class="stat-value">
                        {{ $latestReport?->by_status['pending'] ?? 0 }}
                    </strong>
                </article>


                <article class="stat-card stat-archived">
                    <span class="stat-label">Archivadas</span>

                    <strong class="stat-value">
                        {{ $latestReport?->by_status['archived'] ?? 0 }}
                    </strong>
                </article>

            </div>


            {{-- Requests grouped by organization. --}}
            <section class="dashboard-section">

                <div class="section-header">
                    <h2>Solicitudes por organización</h2>
                </div>

                @if ($latestReport && $latestReport->by_organization)

                <div class="organization-list">

                    {{-- Get the highest number of requests to calculate relative bar widths. --}}
                    @php
                        $maxOrganizationTotal = max($latestReport->by_organization);
                    @endphp

                    @foreach ($latestReport->by_organization as $organization => $total)

                        <div class="organization-row">

                            <div class="organization-info">

                                <span class="organization-name">
                                    {{ $organization }}
                                </span>

                                <strong class="organization-total">
                                    {{ $total }}
                                </strong>

                            </div>

                            {{-- Display a proportional bar based on the highest organization total. --}}
                            <div class="organization-bar-container">
                                <div
                                    class="organization-bar"
                                    style="width: {{ ($total / $maxOrganizationTotal) * 100 }}%;"
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


            {{-- Recently processed requests. --}}
                <section class="dashboard-section">

                    <div class="section-header">
                        <h2>Actividad reciente</h2>
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

                                            {{-- Display the date and time when the request was processed. --}}
                                            <td class="request-date">
                                                {{ \Illuminate\Support\Carbon::parse($request->processed_at)->format('d/m/Y H:i') }}
                                            </td>

                                            {{-- The request detail modal will be implemented later. --}}
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Ver
                                                </button>
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <p class="empty-message">
                            No hay solicitudes procesadas.
                        </p>

                    @endif

                </section>

        </section>

    </main>

</body>
</html>