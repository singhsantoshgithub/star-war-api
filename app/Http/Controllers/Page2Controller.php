<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\People;
use GuzzleHttp\Client;

class Page2Controller extends Controller {

	private $client;

	public function __construct() {
		$this->client = new Client();
	}

	public function index() {
		return view('page2');
	}

	public function people_internal($number) {
		$url = 'https://swapi.co/api/people/' . $number . '/';
		$people = People::where('url', $url)->count();

		if ($people == 0) {
			dd('This Person is not present in database');
		} else {
			$films_url = json_decode(People::where('url', $url)->first()->json_dump)->films;

			$films = [];

			foreach ($films_url as $film_url) {
				$response = $this->client->request('GET', $film_url);
				$result = json_decode($response->getBody()->getContents());
				array_push($films, $result);
			}

			return view('characters-internal', ['films' => $films]);
		}
	}

	public function film_internal($number) {

		$url = 'https://swapi.co/api/films/' . $number . '/';
		$film = Film::where('url', $url)->count();

		if ($film == 0) {
			dd('This film is not present in database');
		} else {

			$peoples_url = json_decode(Film::where('url', $url)->first()->json_dump)->characters;

			$peoples = [];

			foreach ($peoples_url as $people_url) {
				$response = $this->client->request('GET', $people_url);
				$result = json_decode($response->getBody()->getContents());
				array_push($peoples, $result);
			}

			return view('film-internal', ['peoples' => $peoples]);
		}
	}
}
