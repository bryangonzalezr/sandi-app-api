# Sandi-App API

## Requisitos
* WSL 2 (Con ubuntu idealmente)
* Docker

## Instrucciones de instalación

 1. Clonar el proyecto desde WSL.
 2. Copiar `.env.example` a `.env` (`cp .env.example .env`)
 3. Llenar `.env`.
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

---
