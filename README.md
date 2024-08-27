# Sandi-App API

## Requisitos
* WSL 2 (Con ubuntu idealmente)
* Docker

## Instrucciones de instalación

 1. Clonar el proyecto desde WSL.
 2. Copiar `.env.example` a `.env` (`cp .env.example .env`)
 3. Llenar `.env`, obligatoriamente los datos para la DB (dejar `DB_HOST=pgsql` y `DBM_HOST=mongo`).
 4. Asegurarse que docker está corriendo.

---

### Instalar dependencias con docker

Ejecutar el siguiente comando:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### Levantar el proyecto con docker usando `sail`

 1. `./vendor/bin/sail build`
 2. `./vendor/bin/sail up -d`
 3. Proyecto está disponible en `localhost` (`localhost:8080`) por defecto.

Opcionalmente se puede crear el siguiente alias para `sail` en `~/.zshrc` o `~/.bashrc`.
```
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

Migraciones
---
Ejecutar solo uno de los dos comandos

### Ejecutar solo migraciones 

```
sail php artisan migrate
```
### Ejecutar migraciones y rellenar BD con datos de prueba (Seeders)

```
sail php artisan migrate:fresh --seed
```
---

### Limpiar cache

* Cada vez que hagas cambios al .env o a las rutas o a algun archivo de la carpeta config, se debe ejecutar:
```
sail php artisan optimize
```
---


