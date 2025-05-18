<?php
// Si se recibe un tipo por GET, procesamos la solicitud
if (isset($_GET['tipo'])) {
    header('Content-Type: application/json');

    // Obtenemos y limpiamos el valor manualmente
    $tipo = isset($_GET['tipo']) ? strtolower(trim($_GET['tipo'])) : '';

    // Validamos que solo contenga letras (por seguridad)
    if (!preg_match('/^[a-z]+$/', $tipo)) {
        http_response_code(400);
        echo json_encode(["error" => "Tipo inválido"]);
        exit;
    }

    // Incluimos las clases necesarias
    require_once 'pokemon-fetcher.php';

    try {
        $fetcher = new PokemonTypeFetcher();
        $resultados = $fetcher->fetch($tipo);
        echo json_encode($resultados);
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
    <title>Buscar Pokémon por tipo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Buscar Pokémon</h2>

        <!-- Selector de tipo -->
        <select id="tipoSelect" style="padding: 0.6rem; width: 100%; border-radius: 50px; margin-bottom: 1rem; border: 2px solid #33407B; background: #ABB7F1; color: #33407B;">
            <option value="">Selecciona un tipo</option>
            <option value="fire">🔥 Fuego</option>
            <option value="water">💧 Agua</option>
            <option value="grass">🍃 Planta</option>
            <option value="electric">⚡ Eléctrico</option>
            <option value="psychic">🔮 Psíquico</option>
            <option value="ice">❄️ Hielo</option>
            <option value="rock">🪨 Roca</option>
            <option value="ghost">👻 Fantasma</option>
        </select>

        <button id="buscarBtn">Buscar</button>

        <!-- Contenedor de resultados -->
        <div class="pokemon-card pokemon-scroll" id="resultados"></div>

        <a href="index.php" class="back">Volver al menú</a>
    </div>

    <script>
        const btn = document.getElementById("buscarBtn");
        const tipo = document.getElementById("tipoSelect");
        const resultados = document.getElementById("resultados");

        btn.addEventListener("click", async () => {
            const valor = tipo.value;
            if (!valor) {
                resultados.innerHTML = "<p style='color:red;'>⚠️ Debes seleccionar un tipo</p>";
                return;
            }

            resultados.innerHTML = "Cargando...";

            try {
                const res = await fetch(`pokemon-tipo.php?tipo=${valor}`);
                if (!res.ok) throw new Error("Respuesta inválida");

                const data = await res.json();
                resultados.innerHTML = "";

                data.forEach(poke => {
                    resultados.innerHTML += `
                        <div style="margin-bottom:1rem;">
                            <h3>${poke.nombre}</h3>
                            <img src="${poke.imagen}" alt="${poke.nombre}">
                        </div>
                    `;
                });
            } catch (error) {
                resultados.innerHTML = "<p style='color:red;'>❌ Error al obtener Pokémon</p>";
                console.error(error);
            }
        });
    </script>
</body>
</html>
