<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\IbgeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeServiceTest extends TestCase
{
    public function test_it_fetches_states_from_api_and_caches_them(): void
    {
        // Simulamos (Mock) a resposta do IBGE
        Http::fake([
            'servicodados.ibge.gov.br/*' => Http::response([
                ['id' => 33, 'sigla' => 'RJ', 'nome' => 'Rio de Janeiro'],
                ['id' => 35, 'sigla' => 'SP', 'nome' => 'São Paulo'],
            ], 200)
        ]);

        $service = new IbgeService();

        // 2. Act (Ação)
        $states = $service->getStates();

        // 3. Assert (Verificação)
        $this->assertCount(2, $states);
        $this->assertEquals('Rio de Janeiro', $states[0]['nome']);

        // Verifica se salvou no cache com a chave correta
        $this->assertTrue(Cache::has('ibge_states'));
    }

    public function test_it_fetches_cities_for_a_given_state(): void
    {
        Http::fake([
            'servicodados.ibge.gov.br/*' => Http::response([
                ['id' => 123, 'nome' => 'Copacabana'],
            ], 200)
        ]);

        $service = new IbgeService();
        $cities = $service->getCitiesByState(33);

        $this->assertCount(1, $cities);
        $this->assertEquals('Copacabana', $cities[0]['nome']);
        // Verifica cache específico daquele estado
        $this->assertTrue(Cache::has('ibge_cities_33'));
    }
}
