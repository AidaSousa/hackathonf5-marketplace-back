<?php

namespace Tests\Feature\Api;

use App\Models\Pisos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PisosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function pisos_page_is_accessible()
    {
        $this->get('api/pisos')
            ->assertOk();
    }

    /** @test */
    public function index_returns_all_posts()
    {
        // creamos y guardamos lo que esperamos
        User::factory()->count(3)->create();
        Pisos::factory()->count(3)->create();
        $expectedProjects = Pisos::all();

        // y guardamos la respuesta a comparar
        $response = $this->get('http://localhost:8000/api/pisos/');

        // verificacion
        $response->assertSuccessful();
        $response->assertJsonCount($expectedProjects->count());
        $response->assertJson($expectedProjects->toArray());
    }


    /**
     * Test the show method of the PisosController.
     *
     * @return void
     */
    public function a_posts_can_be_shown()
    {
        // Creamos datos
        $user = User::factory()->create();
        $piso = Pisos::factory()->create(['user_id' => $user->id]);

        // hacemos get
        $response = $this->get('http://localhost:8000/api/pisos/' . $piso->id);

        // assert
        $response->assertSuccessful();

        // verificamos que lso datos sean los correctos
        $response->assertJson([
            'id' => $piso->id,
            'titulo' => $piso->titulo,
            'ciudad' => $piso->ciudad,
            'zona' => $piso->zona,
            'precio' => $piso->precio,
            'planta' => $piso->planta,
            'extension' => $piso->extension,
            'habitaciones' => $piso->habitaciones,
            'baños' => $piso->baños,
            'descripcion' => $piso->descripcion,
            'caracteristicas' => $piso->caracteristicas,
            'fotos' => $piso->fotos,
            'isFavorite' => $piso->isFavorite,
            'propietario' => $piso->propietario,
        ]);
    }

    /** @test */

    public function a_post_can_be_stored_without_images()
    {
        $user = User::factory()->create();
        $data = [
            "user_id" => $user->id,
            "titulo" => "Aqui está mi oferta",
            "ciudad" => "barcelona",
            "zona" => "Badalona",
            "precio" => 250000,
            "planta" => "1ro 1ra",
            "extension" => 55,
            "habitaciones" => 3,
            "baños" => 3,
            "descripcion" => "esto es una muy buena descripcion si",
            "isFavorite" => 1,
            "propietario" => "Alessandro Ar",
        ];

        $response = $this->post('/api/pisos', $data);
        $response->assertSuccessful();

        $this->assertDatabaseHas('pisos', [
            "user_id" => $user->id,
            "titulo" => "Aqui está mi oferta",
            "ciudad" => "barcelona",
            "zona" => "Badalona",
            "precio" => 250000,
            "planta" => "1ro 1ra",
            "extension" => 55,
            "habitaciones" => 3,
            "baños" => 3,
            "descripcion" => "esto es una muy buena descripcion si",
            "isFavorite" => 1,
            "propietario" => "Alessandro Ar",
        ]);
    }

    public function test_a_posts_can_be_updated()
    {
        // creamos user y piso, y añadimos los datos que queremos añadir en data
        $user = User::factory()->create();
        $piso = Pisos::factory()->create();
        $data = [
            "user_id" => $user->id,
            "titulo" => "Aqui está mi oferta",
            "ciudad" => "barcelona",
            "zona" => "Badalona",
            "precio" => 250000,
            "planta" => "1ro 1ra",
            "extension" => 55,
            "habitaciones" => 3,
            "baños" => 3,
            "descripcion" => "esto es una muy buena descripcion si",
            "isFavorite" => 1,
            "propietario" => "Alessandro Ar",
        ];
        

        // hacemos un patch/update en el piso, añadiendo el id correspondiente
        $response = $this->put('http://localhost:8000/api/pisos/' . $piso->id, $data);
        $response->assertStatus(200);
        
        // importante cambiarlo a json para poder acceder a sus propiedades
        $updatedPisos = $this->get('http://localhost:8000/api/pisos/' . $piso->id)->json();
        $this->assertEquals($data['titulo'], $updatedPisos['titulo']);
        $this->assertEquals($data['baños'], $updatedPisos['baños']);
        $this->assertEquals($data['habitaciones'], $updatedPisos['habitaciones']);
    }

    public function test_a_posts_can_be_deleted()
    {
        $user = User::factory()->create();
        $project = Pisos::factory()->create();
        $response = $this->delete("api/pisos/{$project->id}");
        $response->assertStatus(204);

        // aseguramos que este proyecto no esté en la base de datos
        $this->assertDatabaseMissing('pisos', $project->toArray());
    }

    // test incompleto, quedaría hacer assert y que devuelva algún string, tocaría modificar el CRUD para ello también
    public function test_delete_non_existing_posts()
    {
        $response = $this->delete("api/pisos/666");
        $response->assertStatus(404);
    }
}
