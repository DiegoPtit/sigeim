# Contexto y Requisitos del Proyecto: SIGEIM (Sistema de Gestión de Encolado de Impresiones)

Actúa como un Arquitecto de Software y Full-Stack Developer experto en PHP, SQL, Bootstrap y Docker.

## 1. Objetivo del Proyecto
Desarrollar un microsistema web local llamado **SIGEIM** para gestionar y encolar solicitudes de impresión y copias institucionales. El sistema centralizará las peticiones de los empleados para tener métricas precisas y evitar el desorden de documentos.

**Enfoque de datos:** 
Un documento padre (el proceso) puede tener múltiples copias hijas (con atributos únicos: color/blanco y negro, orientación, páginas específicas, reducción/ampliación). 

**Módulos principales:**
1. **Admin:** Visualización del repositorio de archivos y métricas generales.
2. **Cola:** Dashboard para visualizar el encolado de documentos pendientes y en proceso.
3. **Subida:** Formulario intuitivo para que los empleados configuren sus copias y suban el documento (PDF, Imagen, Word).

## 2. Arquitectura de Infraestructura (Docker)
El sistema correrá bajo un entorno aislado usando Docker y Docker Compose (ya que el servidor host es un Debian 8 legacy).
Necesito que generes los archivos `docker-compose.yml` y el `Dockerfile` correspondientes con las siguientes especificaciones:

*   **Servicio Web (PHP + Apache/Nginx):** 
    *   Imagen base: `php:8.2-apache` (o similar, optimizada).
    *   Habilitar extensiones necesarias: `pdo_mysql`, `gd`, `zip`.
    *   Exponer puerto 80.
*   **Servicio de Base de Datos (MariaDB/MySQL):**
    *   Imagen base: `mysql:8.0`.
    *   Variables de entorno estándar (root password: 123, database: sigeim_db, user: root, password: 123).
    *   Volumen persistente para los datos.
*   **Volúmenes adicionales:**
    *   Un volumen mapeado para la carpeta de almacenamiento de documentos (`storage/`), separada del código fuente.

## 3. Estructura de Directorios (Scaffolding)
Genera la estructura de archivos necesaria siguiendo esta distribución para un escalado limpio:

```text
/
├── docker/           # Configuraciones específicas de Docker (vhosts, php.ini)
├── databases/        # Migraciones y seeds (usando una herramienta como Phinx o migraciones nativas)
├── public/           # Punto de entrada (index.php) y assets compilados
│   ├── assets/       # CSS, JS, Imágenes
│   └── index.php
├── src/              # Lógica de negocio (Clases, Modelos, Controladores)
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   └── Helpers/
├── templates/        # Vistas/Plantillas (usando PHP nativo o Twig)
├── storage/          # Archivos subidos y logs
├── .env              # Configuración de entorno
└── docker-compose.yml
```

## 4. Stack Tecnológico y Diseño

* **Backend:** PHP 8.2+ con una estructura MVC simple o basada en servicios.
* **Frontend:** Bootstrap 5 para el diseño responsive y componentes UI.
* **Iconografía:** Lucide Icons (local).
* **Tipografía:** Inter (local).
* **Base de Datos:** MySQL/MariaDB con gestión de migraciones para control de versiones del esquema.
* **Temas:** Soporte para modo claro y oscuro basado en Bootstrap.
* **Almacenamiento:** Gestión robusta de archivos en la carpeta `storage/`.

## 5. Tareas a Ejecutar (Próximamente)

1. Redefinir `Dockerfile` y `docker-compose.yml` para el stack PHP.
2. Crear el scaffolding base con el ruteo básico y conexión a DB.
3. Implementar un sistema de migraciones simple.
4. Diseñar la interfaz responsive inicial con Bootstrap. Un simple "Hola Mundo" bastará.
