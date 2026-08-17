# FormsFlow

**Plataforma demostradora de formularios digitales, integración de datos y automatización de procesos.**

FormsFlow es un proyecto full-stack desarrollado con Laravel que reproduce, a pequeña escala, un flujo de trabajo de gestión digital de solicitudes:

```text
Formulario
    ↓
API REST
    ↓
Base de datos
    ↓
ETL
    ↓
Explotación del dato
    ↓
Automatización
    ↓
Clasificación NLP
````

El proyecto está planteado como un demostrador técnico de desarrollo de soluciones digitales, integración, gestión de datos, automatización y aplicación de técnicas de PLN.

---

## 🎯 Objetivo

**Construir una aplicación web completa que simule el ciclo de gestión de una solicitud administrativa digital**, desde su presentación mediante formulario hasta su almacenamiento, procesamiento, clasificación y explotación del dato.

* Desarrollo de aplicaciones web con Laravel.
* Diseño y gestión de bases de datos relacionales.
* Desarrollo y consumo de APIs REST.
* Diseño de formularios digitales y validación de datos.
* Procesos ETL.
* Automatización de tareas.
* Explotación y visualización de datos.
* Aplicación de técnicas de PLN para clasificación.
* Testing.
* Contenerización con Docker.
* Integración continua.
* Documentación técnica.

La inteligencia artificial/PLN será un **componente auxiliar del sistema**, no el objetivo principal de la aplicación.

---
## 📋 Caso de uso

FormsFlow simula una plataforma de gestión de solicitudes dirigidas a un organismo público.

El ciudadano puede presentar una solicitud mediante un formulario digital, indicando sus datos de contacto, el organismo destinatario, el asunto, una descripción de la situación (`Expone`) y la actuación que solicita (`Solicita`).

La aplicación registra y gestiona estas solicitudes y, posteriormente, permite procesar los datos mediante procesos ETL y aplicar un componente de PLN para clasificar automáticamente las solicitudes y establecer una prioridad orientativa.

El proyecto utiliza un **caso de uso ficticio**, inspirado en los patrones habituales de los formularios administrativos electrónicos, sin utilizar datos personales ni tramitar solicitudes reales.

### Flujo funcional

```text
Formulario ciudadano
        ↓
Registro de solicitud
        ↓
Validación
        ↓
PostgreSQL
        ↓
ETL
        ↓
Clasificación NLP
        ↓
Prioridad y categoría
        ↓
Explotación del dato
        ↓
Automatización
```
---
### Modelo de datos

La entidad principal del sistema es `Solicitud`, que representa una solicitud administrativa presentada mediante el formulario digital.

La solicitud contiene:

- Datos del solicitante.
- Organismo y unidad destinataria.
- Asunto.
- Exposición (`Expone`).
- Petición (`Solicita`).
- Estado de tramitación.
- Categoría y prioridad.

La categoría y la prioridad se incorporarán posteriormente mediante el procesamiento automático del sistema.

```text
Formulario
    ↓
Solicitud
    ↓
PostgreSQL
    ↓
ETL / NLP
    ↓
Categoría + prioridad

**Datos principales de una solicitud**
Solicitud
├── Datos del solicitante
├── Destino
├── Asunto
├── Expone
├── Solicita
├── Estado
├── Categoría
└── Prioridad

**Tipos de solicitudes**

Información → consultas sobre servicios o procedimientos.
Incidencia → comunicación de un problema en un servicio.
Documentación → solicitudes relacionadas con documentos o certificados.
---

## 🏗️ Arquitectura

La aplicación se desarrollará sobre una arquitectura basada en contenedores:

```text
┌───────────────────────────────┐
│          FormsFlow            │
│                               │
│  ┌─────────────────────────┐  │
│  │       Laravel 12        │  │
│  │       PHP 8.3           │  │
│  └────────────┬────────────┘  │
│               │               │
│               ▼               │
│  ┌─────────────────────────┐  │
│  │      PostgreSQL 16      │  │
│  └─────────────────────────┘  │
│                               │
└───────────────────────────────┘
```

El componente de PLN se incorporará posteriormente como un servicio independiente.

---

## 🛠️ Stack tecnológico

| Tecnología     | Uso                         |
| -------------- | --------------------------- |
| Laravel 12     | Backend y aplicación web    |
| PHP 8.3        | Lenguaje de backend         |
| PostgreSQL 16  | Base de datos               |
| Docker         | Contenerización             |
| Docker Compose | Orquestación local          |
| Composer       | Gestión de dependencias PHP |
| PHPUnit        | Testing                     |
| Git / GitHub   | Control de versiones        |
| GitHub Actions | Integración continua        |
| Python         | Componente NLP              |
| FastAPI        | API del servicio NLP        |
| scikit-learn   | Clasificación de texto      |

> Los componentes que todavía no se han implementado se incorporarán progresivamente durante el desarrollo.

---

## 🚀 Estado del proyecto

### Día 1 — Infraestructura

* [x] Docker Desktop configurado.
* [x] Docker Compose funcionando.
* [x] PHP 8.3 configurado.
* [x] Composer configurado.
* [x] Laravel 12.66.0 instalado.
* [x] PostgreSQL 16 configurado.
* [x] Laravel conectado con PostgreSQL.
* [x] Migraciones iniciales ejecutadas.
* [x] Aplicación accesible mediante Docker.
* [x] Repositorio Git inicializado.
* [x] Primer commit realizado.
* [x] Repositorio GitHub creado.

### Próximas fases

* [ ] Diseño del modelo de datos.
* [ ] Formularios digitales.
* [ ] Gestión de solicitudes.
* [ ] API REST.
* [ ] Pipeline ETL.
* [ ] Dashboard y explotación de datos.
* [ ] Automatización mediante Jobs y Scheduler.
* [ ] Servicio NLP.
* [ ] Testing funcional y de API.
* [ ] CI/CD.
* [ ] Documentación de API.
* [ ] Despliegue de demo pública.

---

## 🐳 Instalación

### Requisitos

* Docker Desktop
* Git

No es necesario instalar PHP, Composer o PostgreSQL directamente en el equipo, ya que forman parte del entorno Docker.

### Ejecutar el proyecto

Clonar el repositorio:

```bash
git clone git@github.com:viorbe20/formsflow.git
cd formsflow
```

Crear el archivo de configuración:

```bash
cp .env.example .env
```

Arrancar los servicios:

```bash
docker compose up -d
```

Ejecutar las migraciones:

```bash
docker compose exec app php artisan migrate
```

La aplicación estará disponible en:

```text
http://localhost:8000
```

---

## 🧪 Testing

El proyecto utilizará PHPUnit para las pruebas automatizadas.

Las pruebas se ejecutarán dentro del contenedor Docker:

```bash
docker compose exec app php artisan test
```

La estrategia de testing incluirá progresivamente:

* Tests unitarios.
* Tests de funcionalidades.
* Tests de API.
* Validación de formularios.
* Tests de procesos de datos.

---

## 📚 Documentación

La documentación del proyecto se encuentra en evolución junto con el desarrollo.

Incluye:

* Arquitectura.
* Modelo de datos.
* API REST.
* Procesos ETL.
* Automatizaciones.
* Componente NLP.
* Decisiones técnicas.
* Testing.
* Despliegue.

El seguimiento del desarrollo se mantiene en [`timeline.md`](timeline.md).

---

## 🔗 Enlaces

**Repositorio:**
[https://github.com/viorbe20/formsflow](https://github.com/viorbe20/formsflow)

**Demo pública:**
*Pendiente de despliegue.*

---

## 📄 Licencia

Proyecto demostrador desarrollado con fines de portfolio y acreditación de competencias técnicas.

```

### Una decisión importante

**Yo pondría este README ya**, pero no haría todavía un commit de todo el README definitivo. Este será nuestro **README vivo**: cada vez que implementemos una parte real, actualizamos su estado.

Así evitamos el problema típico de los proyectos de portfolio: un README que promete API + ETL + IA + CI/CD, pero al entrar al código todavía no existe.

Ahora mismo podemos decir honestamente:

> **Infraestructura Docker + Laravel 12 + PostgreSQL funcionando.**

Y mañana, cuando construyamos la primera pieza, el README avanzará con ella.
```
