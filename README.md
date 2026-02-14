# � Guía de Configuración: SENA Académico (MVC)

Esta guía explica paso a paso cómo poner en marcha el proyecto, configurar la base de datos y entender la arquitectura de rutas y seguridad.

---

## 1. 📂 Estructura y Conceptos Clave

### 🛡️ Seguridad con `.env` y `EnvLoader.php`
- **¿Para qué sirve?**: En lugar de escribir tu contraseña dentro de los archivos de PHP (lo cual es inseguro), la guardamos en el archivo `.env`.
- **EnvLoader.php**: Es el encargado de leer ese archivo y "prestarle" los datos a la clase `Conexion.php`. Si mañana cambias de contraseña, **solo editas el .env**.

### � Gestión de Rutas Maestras
- El proyecto usa `dirname(dirname(__DIR__))`.
- **¿Por qué?**: Esto hace que las rutas sean **absolutas e inteligentes**. No importa si usas Laragon o XAMPP, el sistema siempre sabrá dónde están las carpetas `model`, `view` y `controller` sin perderse.

---

## 2. 🔌 Configuración del Servidor (Paso a Paso)

Elige tu servidor local:

### 🟢 Opción A: Laragon (Recomendado)
1. **Activar Extensiones**:
   - Click derecho en el botón de Laragon -> **PHP** -> **Extensiones**.
   - Asegúrate de que `pdo_pgsql` y `pgsql` tengan el check (para PostgreSQL).
   - O `pdo_mysql` y `mysqli` (para MySQL).
2. **Carpeta**: Coloca el proyecto en `C:\laragon\www\MVC`.

### 🟠 Opción B: XAMPP
1. **Activar Extensiones**:
   - Abre el **XAMPP Control Panel**.
   - En la fila de Apache, haz clic en **Config** -> **PHP (php.ini)**.
   - Busca (Ctrl + B) la línea `;extension=pdo_pgsql` y quítale el punto y coma `;` inicial. Haz lo mismo con `;extension=pgsql`.
   - **Guarda el archivo** y dale a **Stop** y luego **Start** en Apache.
2. **Carpeta**: Coloca el proyecto en `C:\xampp\htdocs\MVC`.

---

## 3. 🗄️ Configuración de la Base de Datos (.env)

Abre el archivo `.env` en la raíz y configura según tu motor:

### 🐘 Usando PostgreSQL
```env
DB_DRIVER=pgsql
DB_PORT=5432
DB_HOST=localhost
DB_NAME=transversal
DB_USER=postgres
DB_PASS=tu_contraseña_de_postgres
```

### � Usando MySQL
```env
DB_DRIVER=mysql
DB_PORT=3306
DB_HOST=localhost
DB_NAME=transversal
DB_USER=root
DB_PASS=          # En XAMPP suele estar vacío
```

---

## 4. 🔍 Verificación (¿Cómo saber si todo está bien?)

1. Abre tu navegador y ve a: `http://localhost/MVC/mvc_programa/debug_db.php`.
2. El sistema te mostrará una lista verde:
   - ✅ Extensiones PHP cargadas.
   - ✅ Conexión establecida.
   - ✅ Tablas encontradas con su estructura.

---


