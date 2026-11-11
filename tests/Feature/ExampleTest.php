<?php

namespace Tests\Feature;

use App\Models\Prodotto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    private function utente(): User
    {
        $u = new User();
        $u->username = 'mario';
        $u->password = Hash::make('Abcdef1!');
        $u->save();
        return $u;
    }

    private function prodotto(): int
    {
        return \DB::table('prodotti')->insertGetId(['nome' => 'iPhone', 'prezzo' => 10.5]);
    }

    private function logged(): array
    {
        return ['user_id' => $this->utente()->id, 'username' => 'mario'];
    }

    public function test_root_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_pages_do_not_emit_output_before_headers(): void
    {
        foreach (['/login', '/register', '/prodotti'] as $url) {
            $this->assertStringStartsWith('<', ltrim($this->get($url)->getContent()));
        }
        foreach (glob(base_path('routes/*.php')) as $file) {
            $this->assertStringStartsWith('<?php', file_get_contents($file));
        }
    }

    public function test_register_validates_server_side(): void
    {
        $this->post('/register', ['username' => 'a', 'password' => 'debole', 'conferma' => 'x'])
             ->assertSessionHasErrors(['username', 'password', 'conferma']);
        $this->assertDatabaseCount('utenti', 0);
    }

    public function test_register_and_login(): void
    {
        $this->post('/register', ['username' => 'mario', 'password' => 'Abcdef1!', 'conferma' => 'Abcdef1!'])
             ->assertRedirect('login');
        $this->post('/login', ['username' => 'mario', 'password' => 'sbagliata'])
             ->assertSessionHasErrors('credenziali');
        $this->post('/login', ['username' => 'mario', 'password' => 'Abcdef1!'])
             ->assertRedirect('home');
    }

    public function test_login_requires_fields(): void
    {
        $this->post('/login', [])->assertSessionHasErrors(['username', 'password']);
    }

    public function test_protected_pages_redirect_guests(): void
    {
        $this->get('/shopping')->assertRedirect('login');
        $this->get('/checkout')->assertRedirect('login');
        $this->postJson('/shopping/add', ['prodotto_id' => 1])->assertStatus(401);
    }

    public function test_cart_validation_and_flow(): void
    {
        $s = $this->logged();
        $id = $this->prodotto();

        $this->withSession($s)->postJson('/shopping/add', ['prodotto_id' => 999])->assertStatus(422);
        $this->withSession($s)->postJson('/shopping/add', ['prodotto_id' => $id, 'quantita' => 0])->assertStatus(422);
        $this->withSession($s)->postJson('/shopping/add', ['prodotto_id' => $id, 'quantita' => 100])->assertStatus(422);

        $this->withSession($s)->postJson('/shopping/add', ['prodotto_id' => $id, 'quantita' => 2])
             ->assertOk()->assertJson(['success' => true, 'articoli' => 2]);
        $this->withSession($s)->patchJson('/shopping/update', ['prodotto_id' => $id, 'quantita' => 5])
             ->assertJson(['articoli' => 5]);
        $this->withSession($s)->get('/shopping')->assertOk()->assertSee('iPhone');
        $this->withSession($s)->deleteJson('/shopping/remove', ['prodotto_id' => $id])
             ->assertJson(['articoli' => 0]);
    }

    public function test_checkout_requires_address_and_creates_order(): void
    {
        $s = $this->logged();
        $id = $this->prodotto();
        $this->withSession($s)->postJson('/shopping/add', ['prodotto_id' => $id, 'quantita' => 2]);

        $this->withSession($s)->post('/checkout', ['indirizzo_spedizione' => 'x'])
             ->assertSessionHasErrors('indirizzo_spedizione');

        $r = $this->withSession($s)->post('/checkout', ['indirizzo_spedizione' => 'Via Roma 1, Catania']);
        $r->assertRedirect();
        $this->assertDatabaseHas('ordini', ['utente_id' => $s['user_id'], 'totale' => 21.00]);
        $this->assertDatabaseCount('ordine_prodotti', 1);
        $this->withSession($s)->get($r->headers->get('Location'))->assertOk()->assertSee('Via Roma 1');
        $this->withSession($s)->get('/checkout')->assertRedirect('shopping');
    }

    public function test_search_filters_products(): void
    {
        $this->prodotto();
        $this->get('/prodotti?nome=iPh')->assertSee('iPhone');
        $this->get('/prodotti?nome=zzz')->assertSee('Nessun prodotto trovato');
        $this->get('/prodotti?nome=' . str_repeat('a', 101))->assertSessionHasErrors('nome');
    }
}
