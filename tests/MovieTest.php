<?php

use App\Http\Controllers\TokenController;
use Tests\TestCase;

class MovieTest extends TestCase
{
    /**
     * /movies [GET]
     */
    public function testShouldReturnAllMovies(){
        $token = (new TokenController)->getToken();
        $token = json_decode(json_encode($token))->original->token;
        $this->get("api/movies", ['token' => $token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id',
                    'title',
                    'description',
                    'rating',
                    'image',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);

    }

    /**
     * /movies/id [GET]
     */
    public function testShouldReturnMovies(){
        $token = (new TokenController)->getToken();
        $token = json_decode(json_encode($token))->original->token;

        $this->get("api/movies/2", ['token' => $token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([['data'][0]]);
    }

    /**
     * /movies [POST]
     */
    public function testShouldCreateMovie(){

        $parameters = [
            'title' => 'Test Movie',
            'rating' => 4.5,
            'description' => 'Testing Movie'
        ];

        $token = (new TokenController)->getToken();
        $token = json_decode(json_encode($token))->original->token;

        $this->post("api/movies", $parameters, ['token' => $token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(['status']);

    }

    /**
     * /movies/id [PUT]
     */
    public function testShouldUpdateMovie(){

        $parameters = [
            'title' => 'Test Movie',
            'rating' => 4.5,
            'description' => 'Testing Movie',
            '_method' => 'PUT'
        ];

        $token = (new TokenController)->getToken();
        $token = json_decode(json_encode($token))->original->token;

        $this->put("api/movies/4", $parameters, ['token' => $token]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(['status']);
    }

    /**
     * /movies/id [DELETE]
     */
    public function testShouldDeleteProduct(){
        $token = (new TokenController)->getToken();
        $token = json_decode(json_encode($token))->original->token;
        $this->delete("api/movies/10", [], ['token' => $token]);
        $this->seeStatusCode(410);
        $this->seeJsonStructure(['status']);
    }

}
?>
