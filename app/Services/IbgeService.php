<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IbgeService
{
    private const BASE_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades';

    private const CACHE_TTL = 2592000; // 30 dias em segundos

    /**
     * Retorna a lista de UFs ordenadas por nome.
     */
    public function getStates(): array
    {
        return Cache::remember('ibge_states', self::CACHE_TTL, function () {
            $response = Http::get(self::BASE_URL.'/estados', [
                'orderBy' => 'nome',
            ]);

            return $response->json() ?? [];
        });
    }

    /**
     * Retorna a lista de municípios de uma UF específica.
     */
    public function getCitiesByState(string|int $ufId): array
    {
        $cacheKey = "ibge_cities_{$ufId}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ufId) {
            $response = Http::get(self::BASE_URL."/estados/{$ufId}/municipios", [
                'orderBy' => 'nome',
            ]);

            return $response->json() ?? [];
        });
    }
}
