#### DÍA 1 — Cimientos de FormsFlow

Al terminar el día debemos tener esto:

FormsFlow
│
├── Git inicializado
├── Laravel funcionando
├── Docker funcionando
├── PostgreSQL funcionando
├── Laravel conectado a PostgreSQL
├── .env correctamente configurado
├── primera migración funcionando
├── tests iniciales funcionando
└── README actualizado

#### 1. Creación del proyecto
**Docker Desktop con backend WSL 2.** 
docker --version
Docker version 29.7.2, build a7dcaa6
docker compose version
Docker Compose version v5.4.0

C:\Users\vober\Documents\projects\formsflow
│
├── Laravel 12
│      │
│      └── PHP 8.3
│
├── PostgreSQL
│
└── Docker Compose


#### 2. Creación del directorio

C:\Users\vober\Documents\projects\formsflow

#### 3. Creación el entorno Docker antes de crear Laravel.

* La idea es que Docker sea quien proporcione PHP y Composer. Así no dependemos de que tengas PHP/Composer instalados en Windows.
* Crear el ``compose.yaml``
   - Vamos a empezar por el archivo que coordinará nuestros contenedores.
   - En el directorio, comando ``code .`` Esto debería abrir esta carpeta formsflow en VS Code.
   - Cuando se abra VS Code, crea un archivo nuevo en la raíz llamado: ``compose.yaml``
   - Nuestro compose.yaml va a definir dos contenedores:
      ```text
      FormsFlow
      │
      ├── app
      │   └── PHP 8.3 + Composer + Laravel
      │
      └── db
         └── PostgreSQL 16
      ```
   - Completamos el archivo. Esto hará que podamos acceder desde Windows a ``http://localhost:8000``
      ```yaml
      app:
      ports:
         - "8000:8000" 
      ```
   - Docker descargará PostgreSQL 16 directamente desde Docker Hub. No instalaremos PostgreSQL en Windows.
      ```yaml
      db:
      image: postgres:16 
      ```
   - Volumen. Esto es importante. Aunque eliminemos el contenedor de PostgreSQL, los datos podrán permanecer en el volumen Docker.
      ```yalm
         postgres_data:/var/lib/postgresql/data
      ```
* Crear DockerFile
   - La línea ``FROM php:8.3-cli`` significa que significa nuestro contenedor parte de PHP 8.3.

   - La línea ``COPY --from=composer:2 /usr/bin/composer /usr/bin/composer`` hace que Composer esté dentro del contenedor. Por tanto, en Windows no necesitamos instalar Composer.

#### Construir el contenedor PHP
* Ejecutamos `docker compose build`. Docker tendrá que:
   - descargar PHP 8.3;
   - instalar las extensiones;
   - descargar Composer;
   - construir nuestra imagen de FormsFlow.

* ``✔ Image formsflow-app Built   `` indica que la imagen se ha construido correctamente.

* Comprobación del funcionamiento de la imagen:
`docker compose run --rm app php -v`
`docker compose run --rm app composer --version`
`docker compose run --rm app php -m`


| Componente     | Resultado |
| -------------- | --------- |
| Docker         | ✅         |
| Docker Compose | ✅         |
| WSL 2          | ✅         |
| PostgreSQL 16  | ✅         |
| PHP            | ✅ 8.3.33  |
| Composer       | ✅ 2.10.2  |
| `pdo_pgsql`    | ✅         |
| `pgsql`        | ✅         |
| `mbstring`     | ✅         |
| `bcmath`       | ✅         |
| `intl`         | ✅         |
| `zip`          | ✅         |

* Al ejecutar docker compose run, Compose ha creado automáticamente la red y el volumen de PostgreSQL y ha arrancado el contenedor formsflow_db. Eso confirma que nuestra definición de Compose está funcionando.

#### 4. Construir Laravel

Objetivo: En FormsFlow queremos ejecutar Laravel dentro de Docker, sin necesidad de instalar PHP, Composer o PostgreSQL 
directamente en Windows.

Ejecutar:

`docker compose run --rm app sh -c "composer create-project --prefer-source laravel/laravel:^12.0 /tmp/laravel && cp -a /tmp/laravel/. /var/www/html/"`

para crear un contenedor temporal con nuestro entorno PHP, ejecutar Composer dentro de él, obtener las dependencias preferentemente mediante Git, generar un proyecto Laravel 12 en `/tmp/laravel` y, si la instalación termina correctamente, copiar el proyecto a `/var/www/html`, que corresponde a nuestra carpeta `formsflow`; cuando termina, el contenedor temporal se elimina.

Hace esto, por partes:

`docker compose run`  
→ Crea y ejecuta un contenedor temporal utilizando Docker Compose.

`--rm`  
→ Elimina automáticamente ese contenedor cuando termina.

`app`  
→ Utiliza el servicio `app` definido en nuestro `compose.yaml`.

`sh -c`  
→ Permite ejecutar varios comandos dentro del contenedor como una única instrucción.

`composer`  
→ Ejecuta Composer dentro del contenedor, no en Windows.

`create-project`  
→ Le indica a Composer que cree un proyecto nuevo.

`--prefer-source`  
→ Indica a Composer que prefiera obtener las dependencias desde sus repositorios de código fuente mediante Git en lugar de utilizar preferentemente archivos comprimidos (`dist`). Lo utilizamos porque las descargas anteriores desde GitHub estaban devolviendo errores `HTTP 429 (Too Many Requests)`.

`laravel/laravel:^12.0`  
→ Indica que queremos crear un proyecto basado en Laravel 12.x.

`/tmp/laravel`  
→ Indica dónde crear inicialmente el proyecto Laravel dentro del contenedor.

`&&`  
→ Hace que el segundo comando solamente se ejecute si `composer create-project` termina correctamente.

`cp -a /tmp/laravel/. /var/www/html/`  
→ Copia todos los archivos del proyecto Laravel creado en `/tmp/laravel` a `/var/www/html`.

`/var/www/html`  
→ Es el directorio de trabajo del contenedor `app` y está conectado mediante un volumen con nuestra carpeta local:

`C:\Users\vober\Documents\projects\formsflow`

Por tanto, la copia realizada dentro del contenedor hace que Laravel quede disponible directamente en nuestra carpeta local de FormsFlow.

Queda instalado Laravel Framework 12.66.0
Flujo

```
Windows
│
│ C:\Users\vober\Documents\projects\formsflow
│
▼
Docker Compose
│
▼
Contenedor temporal "app"
│
├── PHP 8.3
├── Composer
├── Git
│
├── /tmp/laravel
│      └── Laravel 12
│
└── /var/www/html
       │
       └── volumen → formsflow/
```
#### 5. conectar Laravel con PostgreSQL

**Objetivo**

Laravel se ha creado inicialmente utilizando SQLite, que es la configuración predeterminada de una instalación nueva.

Para FormsFlow vamos a utilizar **PostgreSQL 16**, ejecutándose en un contenedor Docker independiente.

La arquitectura queda:

```text
┌──────────────────────────┐
│      Docker Compose      │
│                          │
│  ┌────────────────────┐  │
│  │      app           │  │
│  │                    │  │
│  │ Laravel 12         │  │
│  │ PHP 8.3            │  │
│  └─────────┬──────────┘  │
│            │             │
│            │ PostgreSQL  │
│            ▼             │
│  ┌────────────────────┐  │
│  │       db           │  │
│  │                    │  │
│  │ PostgreSQL 16      │  │
│  └────────────────────┘  │
│                          │
└──────────────────────────┘
```
#### Configurar el archivo `.env`

Abrir:

```text
.env
````

y configurar los parámetros de conexión a PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=formsflow
DB_USERNAME=formsflow
DB_PASSWORD=formsflow
```


`DB_CONNECTION=pgsql`
→ Indica a Laravel que debe utilizar PostgreSQL como sistema gestor de base de datos.

`DB_HOST=db`
→ Indica el nombre del servicio Docker donde se ejecuta PostgreSQL.

Es importante utilizar:

```env
DB_HOST=db
```

y no:

```env
DB_HOST=localhost
```

porque Laravel se ejecuta dentro del contenedor `app` y PostgreSQL dentro del contenedor `db`.

Docker Compose permite que los servicios se comuniquen utilizando el nombre del servicio:

```text
app
 │
 │ DB_HOST=db
 ▼
db
 │
 ▼
PostgreSQL
```

`DB_PORT=5432`
→ Puerto utilizado por PostgreSQL.

`DB_DATABASE=formsflow`
→ Nombre de la base de datos definida en `compose.yaml`.

`DB_USERNAME=formsflow`
→ Usuario de PostgreSQL definido para FormsFlow.

`DB_PASSWORD=formsflow`
→ Contraseña del usuario de PostgreSQL definida para el entorno local.

> **Importante:** Estas credenciales son únicamente de desarrollo local. No deben utilizarse como credenciales de producción ni publicarse en el repositorio.

#### Arrancar los servicios Docker

Desde la raíz del proyecto:

```powershell
docker compose up -d
```

El parámetro:

```text
-d
```

significa que los contenedores se ejecutan en segundo plano (*detached mode*).

Docker Compose inicia los servicios definidos en `compose.yaml`.

* PostgreSQL está iniciado y saludable.
* El contenedor de Laravel/PHP está iniciado.

#### Ejecutar las migraciones

Una vez iniciados los servicios, se ejecuta:

```powershell
docker compose exec app php artisan migrate
```

`docker compose exec`
→ Ejecuta un comando dentro de un contenedor que ya está ejecutándose.

`app`
→ Indica que el comando se ejecutará dentro del servicio `app`.

`php artisan`
→ Ejecuta Artisan utilizando el PHP del contenedor.

`migrate`
→ Ejecuta las migraciones pendientes de Laravel contra la base de datos configurada en `.env`.

#### Levantar y probar Laravel

Arrancar los servicios Docker:

```powershell
docker compose up -d
````

`-d`
→ Ejecuta los contenedores en segundo plano.

Comprobar que están funcionando:

```powershell
docker compose ps
```

Resultado:

```text
formsflow_app   Up
formsflow_db    Up (healthy)
```

Esto confirma que:

* Laravel/PHP está funcionando.
* PostgreSQL está iniciado y saludable.
* El puerto `8000` está disponible.


Abrir en el navegador:

```text
http://localhost:8000
```

Si aparece la pantalla inicial de Laravel, la aplicación funciona correctamente.

El flujo es:

```text
Navegador
    ↓
localhost:8000
    ↓
formsflow_app
    ↓
Laravel 12
    ↓
PostgreSQL 16
```

> `localhost:8000` es únicamente la dirección de desarrollo local. La demo pública de FormsFlow se desplegará posteriormente en Internet para que pueda probarse directamente desde el CV.


### 6. Preparar Git
