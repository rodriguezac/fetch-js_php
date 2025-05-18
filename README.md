# ⚡ Fetch + PHP: Páginas Dinámicas con Pokémon

Este proyecto demuestra cómo construir **páginas web dinámicas** usando `fetch()` en JavaScript y PHP como backend, comunicándose de manera asíncrona con [PokéAPI](https://pokeapi.co/). La arquitectura sigue principios de **Programación Orientada a Objetos (POO)** con el uso de **interfaces, clases abstractas y clases concretas**, lo que mejora la organización, reutilización de código y escalabilidad.

---

## 🎯 Objetivos

- Mostrar cómo se pueden actualizar partes de una página web sin recargar completamente el documento.
- Utilizar la API `fetch()` de JavaScript para hacer solicitudes HTTP asincrónicas.
- Aplicar buenas prácticas de diseño orientado a objetos en PHP.
- Construir una estructura de backend limpia y escalable usando clases `Fetcher`.

---

## 🧪 Funcionalidades

### 🔍 Buscar por nombre
- Ingresa el nombre de un Pokémon (ej. `pikachu`).
- El sistema obtiene su tipo e imagen desde la PokéAPI.

### 🌿 Buscar por tipo
- Elige un tipo de Pokémon (agua, fuego, eléctrico, etc.).
- Muestra una lista de 6 Pokémon pertenecientes a ese tipo.

### 🎲 Pokémon aleatorio
- Al hacer clic, aparece un Pokémon al azar de la primera generación.

---

## 🧠 Estructura técnica

### 🔧 Backend (PHP)
- `pokemon-fetcher.php`: Contiene la lógica de clases `Fetcher`:
  - `IPokemonFetcher`: Interfaz que define el método `fetch()`.
  - `PokemonFetcherBase`: Clase abstracta con lógica común (llamadas a API, manejo de errores).
  - `PokemonNameFetcher`: Busca por nombre.
  - `PokemonTypeFetcher`: Busca por tipo.
  - `PokemonRandomFetcher`: Devuelve un Pokémon aleatorio.

### 🖥️ Frontend (HTML + JS)
- `index.php`: Menú principal con enlaces a los ejemplos.
- `pokemon.php`: Página para buscar Pokémon por nombre.
- `pokemon-tipo.php`: Página para buscar por tipo.
- `pokemon-random.php`: Página para obtener uno aleatorio.
- `style.css`: Estilo visual con un tema colorido y amigable.

---

## 📁 Estructura del proyecto
```
📁 assets/
│   └── img/
│       └── forest-bg.jpg         ← Imagen de fondo
📄 index.php                      ← Menú principal con enlaces
📄 pokemon.php                    ← Búsqueda de Pokémon por nombre
📄 pokemon-tipo.php               ← Búsqueda de Pokémon por tipo
📄 pokemon-random.php             ← Mostrar Pokémon aleatorio
📄 pokemon-fetcher.php            ← Backend orientado a objetos (clases Fetcher)
📄 style.css                      ← Estilos visuales
 ```

---

## 🚀 Cómo usarlo

1. Clona este repositorio:
   ```bash
   git clone https://github.com/rodriguezac/fetch-js_php.git
2. Coloca el proyecto en tu servidor local (por ejemplo, htdocs en XAMPP).

3. Abre http://localhost/UTPPHP/index.php en tu navegador.

## 🧩 Tecnologías utilizadas

- **HTML5 / CSS3** – Maquetación y diseño responsivo.
- **JavaScript (ES6+)** – Uso de Fetch API y manipulación del DOM.
- **PHP 8+** – Backend modular implementado con Programación Orientada a Objetos (POO).
- **PokéAPI** – API REST gratuita utilizada para obtener datos en tiempo real de Pokémon.

