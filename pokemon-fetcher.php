<?php
// INTERFAZ que define el contrato para cualquier clase que obtenga datos de Pokémon
interface IPokemonFetcher {
    /**
     * Método que deben implementar todas las clases concretas que buscan Pokémon.
     * @param string $param - criterio de búsqueda (nombre o tipo)
     * @return array - resultado con los datos obtenidos
     */
    public function fetch(string $param): array;
}

// CLASE ABSTRACTA base que contiene lógica común para los fetchers
abstract class PokemonFetcherBase implements IPokemonFetcher {
    // URL base de la API de Pokémon (para búsquedas por nombre o ID)
    protected string $apiBase = "https://pokeapi.co/api/v2/pokemon/";

    /**
     * Método auxiliar que obtiene y decodifica una respuesta JSON desde una URL.
     * Lanza excepción si ocurre un error.
     * @param string $url - URL a consultar
     * @return array - datos decodificados
     */
    protected function getJson(string $url): array {
        $response = @file_get_contents($url); // El @ evita warnings en caso de error
        if (!$response) {
            throw new Exception("No se pudo acceder a la API en $url");
        }
        return json_decode($response, true);
    }
}

// CLASE CONCRETA para búsqueda por nombre de Pokémon
class PokemonNameFetcher extends PokemonFetcherBase {
    /**
     * Busca un Pokémon por su nombre.
     * @param string $nombre - nombre del Pokémon
     * @return array - nombre, imagen y tipos
     */
    public function fetch(string $nombre): array {
        $nombre = strtolower(trim($nombre)); // Normalizamos entrada
        $data = $this->getJson($this->apiBase . $nombre); // Llamada a la API

        // Extraemos tipos del Pokémon
        $tipos = array_map(fn($t) => $t['type']['name'], $data['types']);

        return [
            "nombre" => ucfirst($data['name']),
            "imagen" => $data['sprites']['front_default'],
            "tipo"   => implode(', ', $tipos)
        ];
    }
}

// CLASE CONCRETA para búsqueda por tipo de Pokémon (nuevo)
class PokemonTypeFetcher extends PokemonFetcherBase {
    /**
     * Busca varios Pokémon que pertenecen a un tipo específico.
     * @param string $tipo - tipo de Pokémon (ej. fire, water)
     * @return array - lista de nombres e imágenes
     */
    public function fetch(string $tipo): array {
        $tipo = strtolower(trim($tipo));
        $url = "https://pokeapi.co/api/v2/type/" . $tipo;

        $data = $this->getJson($url);
        $pokemonList = [];

        // Limitamos a los primeros 6 Pokémon del tipo
        foreach (array_slice($data['pokemon'], 0, 6) as $pokeData) {
            $pokeUrl = $pokeData['pokemon']['url'];
            $pokeInfo = $this->getJson($pokeUrl);

            $pokemonList[] = [
                "nombre" => ucfirst($pokeInfo['name']),
                "imagen" => $pokeInfo['sprites']['front_default']
            ];
        }

        return $pokemonList;
    }
}
// CLASE CONCRETA para obtener un Pokémon aleatorio
class PokemonRandomFetcher extends PokemonFetcherBase {
    /**
     * Ignora el parámetro, simplemente retorna un Pokémon al azar
     * @param string $param - no se usa, se ignora
     * @return array - nombre, imagen y tipos del Pokémon
     */
    public function fetch(string $param = ''): array {
        $id = rand(1, 151); // Limitado a primera generación
        $data = $this->getJson($this->apiBase . $id);

        $tipos = array_map(fn($t) => $t['type']['name'], $data['types']);

        return [
            "nombre" => ucfirst($data['name']),
            "imagen" => $data['sprites']['front_default'],
            "tipo"   => implode(', ', $tipos)
        ];
    }
}

?>