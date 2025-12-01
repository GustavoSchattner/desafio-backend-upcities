<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonTest extends TestCase
{
    // Reseta o banco em memória a cada teste para começar limpo
    use RefreshDatabase;

    public function test_it_can_list_people(): void
    {
        // Cria 3 pessoas falsas no banco em memória
        Person::factory()->count(3)->create();

        // Acessa a rota
        $response = $this->get(route('people.index'));

        // Verifica se deu 200 OK e se a view correta foi carregada
        $response->assertStatus(200);
        $response->assertViewIs('people.index');
        // Verifica se as pessoas criadas estão visíveis na tela
        $response->assertViewHas('people');
    }

    public function test_it_can_create_a_person_successfully(): void
    {
        $payload = [
            'name' => 'Gustavo',
            'cpf' => '123.456.789-00',
            'email' => 'gustavo@example.com',
            'birth_date' => '1995-10-10',
            'phone_number' => '(27) 99999-9999',
            'address' => 'Rua A, 10',
            'uf_id' => 32, // ES
            'city_id' => 1234, // São Mateus
        ];

        // Faz o POST para a rota de store
        $response = $this->post(route('people.store'), $payload);

        // Verifica se redirecionou para a index
        $response->assertRedirect(route('people.index'));
        $response->assertSessionHas('success');

        // Verifica se salvou no banco
        $this->assertDatabaseHas('people', [
            'email' => 'gustavo@example.com',
            'uf_id' => 32
        ]);
    }

    public function test_it_validates_required_fields(): void
    {
        // Tenta enviar vazio
        $response = $this->post(route('people.store'), []);

        // Espera erro de validação nas chaves name e cpf
        $response->assertSessionHasErrors(['name', 'cpf', 'uf_id']);
    }

    public function test_it_can_delete_a_person(): void
    {
        $person = Person::factory()->create();

        $response = $this->delete(route('people.destroy', $person->id));

        $response->assertRedirect(route('people.index'));

        // Verifica se sumiu do banco
        $this->assertDatabaseMissing('people', ['id' => $person->id]);
    }
}
