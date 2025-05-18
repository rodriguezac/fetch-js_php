<?php
// Si se recibe una solicitud GET con ?random, generamos un Pokémon aleatorio
if (isset($_GET['random'])) {
    header('Content-Type: application/json');

    require_once 'pokemon-fetcher.php';

    try {
        $fetcher = new PokemonRandomFetcher();
        $pokemon = $fetcher->fetch(); // No pasamos parámetro
        echo json_encode($pokemon);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokémon Aleatorio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>¿Qué Pokémon eres?</h2>

        <div class="pokemon-card" id="randomPoke">
            <p>Haz clic para obtener un Pokémon.</p>
        </div>

        <button id="btn">Mostrar</button>

        <br>
        <a href="index.php" class="back">Volver al menú</a>
    </div>

    <script>
        const btn = document.getElementById("btn");
        const div = document.getElementById("randomPoke");

        btn.addEventListener("click", async () => {
            div.innerHTML = "Cargando...";

            try {
                const res = await fetch("pokemon-random.php?random=1");
                if (!res.ok) throw new Error("Error en la respuesta");

                const data = await res.json();

                div.innerHTML = `
                    <h3>${data.nombre.toUpperCase()}</h3>
                    <img src="${data.imagen}" alt="${data.nombre}">
                    <p><strong>Tipo:</strong> ${data.tipo}</p>
                `;
            } catch (error) {
                div.innerHTML = "<p style='color:red;'>❌ No se pudo obtener el Pokémon</p>";
                console.error(error);
            }
        });
    </script>
</body>
</html>
