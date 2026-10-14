# Atelier Códice — Creative Canvas & Worldbuilding Studio

Plataforma creativa espacial para autores, diseñadores narrativos y directores de juego. Combina lienzos 2D interactivos, dossiers de personajes, cartografía con point marks vectoriales, bibliotecas de ambientación sonora y el asistente de inteligencia artificial **Códice AI (Arquitecto Narrativo)**.

---

## 🌟 Características Principales

1. **Lienzo Creativo Espacial (Canvas 2D)**:
   - Conectores vectoriales dinámicos en SVG con degradados suaves y cálculo en tiempo real.
   - Nodos arrastrables (*drag & drop*) con persistencia debounced en backend y base de datos.
   - Modos de inserción rápida para notas de campo, fichas, locaciones y reproductores de audio.

2. **Dossiers de Personajes y Moodboards**:
   - Fichas completas de elenco narrativo con citas célebres, biografías, roles y paletas de color integradas.
   - Búsqueda contextual instantánea.

3. **Cartografía Interactiva con Point Marks**:
   - Mapa vectorizado con pines interactivos y pulsantes.
   - Filtros por sector narrativo (*Sector 01*, *Sector 04*, *Distritos clandestinos*).
   - Drawer lateral deslizante para inspección detallada de inteligencia y nivel de amenaza.

4. **Biblioteca de Lore & Audio Player**:
   - Compendio clasificado de documentos, leyes de mundo y registros sonoros.
   - Reproductor maestro de audio con visualizador de onda SVG interactivo y control de volumen.

5. **Códice AI — Arquitecto Narrativo**:
   - Agente de IA impulsado por OpenRouter y adaptado al universo de la obra.
   - Modos duales: Consulta creativa conversacional y generación directa de elementos con inserción automática al lienzo.

6. **Autenticación y Espacios de Trabajo Aislados**:
   - Login y registro con medidor de seguridad y selección de rol creativo.
   - Auto-aprovisionamiento de universo personal, tablero inicial, nodos de bienvenida y roles para cada creador.

---

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 12 (PHP 8.5)
- **Base de Datos**: PostgreSQL en la nube vía [Neon](https://neon.tech) (Transaction Pooler con SSL)
- **Frontend**: Blade Components, Tailwind CSS v4 con `@theme` custom, Google Fonts (*Newsreader*, *Inter*, *Plus Jakarta Sans*) y Material Symbols.
- **Inteligencia Artificial**: OpenRouter API (`liquid/lfm-2.5-2.6b` / Gemini)
- **Despliegue Serverless**: Optimizado para [Vercel](https://vercel.com) (`vercel.json`, `api/index.php`)

---

## 🚀 Instalación Local

```bash
# 1. Clonar el repositorio
git clone https://github.com/anthra123x/Atelier-C-dice.git
cd Atelier-C-dice

# 2. Instalar dependencias PHP y JavaScript
composer install
npm install

# 3. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar tu base de datos PostgreSQL en .env y correr migraciones y seeders
php artisan migrate --seed

# 5. Compilar assets y levantar el servidor
npm run build
php artisan serve
```

---

## ☁️ Despliegue en Vercel

1. Conecta este repositorio en tu cuenta de [Vercel](https://vercel.com).
2. Configura las siguientes Variables de Entorno en el panel de Vercel:
   - `APP_KEY`: Clave de cifrado de la aplicación.
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `DB_CONNECTION`: `pgsql`
   - `DB_HOST`: Host de tu base de datos Neon (ej. `ep-cool-lake-b71anr61-pooler.c-13.us-east-1.aws.neon.tech`)
   - `DB_PORT`: `5432`
   - `DB_DATABASE`: `neondb`
   - `DB_USERNAME`: Tu usuario de Neon
   - `DB_PASSWORD`: Tu contraseña de Neon
   - `DB_SSLMODE`: `require`
   - `OPENROUTER_API_KEY`: Tu clave de OpenRouter
   - `OPENROUTER_MODEL`: `liquid/lfm-2.5-2.6b:free`
3. Vercel detectará automáticamente `vercel.json` y el punto de entrada `api/index.php`.

---

## 🧪 Pruebas Automatizadas

```bash
php artisan test --compact
```
Suite de pruebas con 100% de cobertura en flujos de autenticación, generación por IA, CRUD de nodos espaciales y rutas del Atelier.

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
