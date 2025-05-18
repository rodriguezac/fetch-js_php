<?php
// Si se recibe una solicitud AJAX con el parámetro 'nombre' (GET),
// procesamos desde el servidor y respondemos con JSON
if (isset($_GET['nombre'])) {
    // Indicamos que la respuesta será en formato JSON
    header('Content-Type: application/json');

    // Cargamos las clases necesarias (interfaz, abstracta y concreta)
    require_once 'pokemon-fetcher.php';

    try {
        // Creamos una instancia de la clase que busca por nombre
        $fetcher = new PokemonNameFetcher();

        // Ejecutamos la búsqueda pasando el nombre recibido por GET
        $resultado = $fetcher->fetch($_GET['nombre']);

        // Devolvemos el resultado como JSON
        echo json_encode($resultado);
    } catch (Exception $e) {
        // Si ocurre algún error (ej. no se encuentra el Pokémon), devolvemos código 404
        http_response_code(404);
        echo json_encode(["error" => $e->getMessage()]);
    }

    // Detenemos el procesamiento HTML
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Buscar Pokémon por nombre</title>
  <!-- Enlace al archivo de estilos externo -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Buscar Pokémon</h2>

    <!-- Formulario para ingresar el nombre del Pokémon -->
    <form id="pokeForm">
      <input type="text" id="nombre" placeholder="Escribe el nombre (ej. pikachu)" required>
      <button type="submit">Buscar</button>
    </form>

    <!-- Contenedor donde se mostrará el resultado -->
    <div class="pokemon-card" id="resultado"></div>

    <!-- Enlace para volver al menú principal -->
    <a href="index.php" class="back">Volver al menú</a>
  </div>

  <script>
    // Obtenemos referencia al formulario y al contenedor de resultados
    const form = document.getElementById('pokeForm');
    const resultado = document.getElementById('resultado');

    // Evento que se ejecuta al enviar el formulario
    form.addEventListener('submit', async (e) => {
      e.preventDefault(); // Evita la recarga de la página al enviar el formulario

      // Obtenemos el valor ingresado, eliminamos espacios y convertimos a minúsculas
      const nombre = document.getElementById('nombre').value.trim().toLowerCase();

      // Mostramos mensaje de carga mientras se realiza la petición
      resultado.innerHTML = "Buscando...";

      try {
        // Realizamos la petición al mismo archivo PHP con el nombre como parámetro
        const res = await fetch(`pokemon-nombre.php?nombre=${nombre}`);

        // Si la respuesta no es válida (ej. 404), lanzamos un error
        if (!res.ok) throw new Error("No encontrado");

        // Convertimos la respuesta en formato JSON
        const data = await res.json();

        // Mostramos la tarjeta del Pokémon con nombre, imagen y tipo
        resultado.innerHTML = `
          <h3>${data.nombre.toUpperCase()}</h3>
          <img src="${data.imagen}" alt="${data.nombre}">
          <p><strong>Tipo:</strong> ${data.tipo}</p>
        `;
      } catch (error) {
        // Si ocurre un error (nombre inválido, conexión, etc.), mostramos mensaje de error
        resultado.innerHTML = "<p style='color:red;'>❌ Pokémon no encontrado</p>";
      }
    });
  </script>
</body>
</html>
 