<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\People;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class AjaxController extends Controller {

	private $client;

	public function __construct() {
		$this->client = new Client();
	}

	public function people_api() {

		$peoples = $this->get_peoples();

		return Datatables::of($peoples)
			->addColumn('name', function ($people) {
				return $people->name;
			})->addColumn('url', function ($people) {
			return $people->url;
		})->addColumn('action', function ($people) {
			$value = Str::after($people->url, 'https://swapi.co/api/people/');
			$value = Str::before($value, '/');
			$value = (int) $value;

			return '<a style="border: 1px solid #000;" class="btn" href="' . route('people-internal', ['number' => $value]) . '">see films</a>';
		})->rawColumns([])->make(true);

	}

	public function people_db() {

		$peoples = People::orderBy('created_at', 'DESC')->get();

		return Datatables::of($peoples)
			->addColumn('name', function ($people) {
				return $people->name;
			})->addColumn('url', function ($people) {
			return $people->url;
		})->addColumn('action', function ($film) {
			return 'No Action';
		})->make(true);

	}

	public function film_api() {

		$films = $this->get_films();
		return Datatables::of($films)->addColumn('name', function ($film) {
			return $film->title;
		})->addColumn('url', function ($film) {
			return $film->url;
		})->addColumn('action', function ($film) {

			$value = Str::after($film->url, 'https://swapi.co/api/films/');
			$value = Str::before($value, '/');
			$value = (int) $value;

			return '<a style="border: 1px solid #000;" class="btn" href="' . route('film-internal', ['number' => $value]) . '">see people</a>';

		})->rawColumns([])->make(true);

	}

	public function film_db() {

		$films = Film::orderBy('created_at', 'DESC')->get();
		return Datatables::of($films)
			->addColumn('name', function ($film) {
				return $film->name;
			})->addColumn('url', function ($film) {
			return $film->url;
		})->addColumn('action', function ($film) {
			return 'No Action';
		})->make(true);

	}

	public function get_peoples() {
		$response = $this->client->request('GET', 'https://swapi.co/api/people');
		$result = json_decode($response->getBody()->getContents());
		$records = $result->results;

		if ($result->next != null) {
			$records = $this->next_peoples($result->next, $records);
		}

		return $records;
	}

	public function next_peoples($next, $prev_records) {

		$response = $this->client->request('GET', $next);
		$result = json_decode($response->getBody()->getContents());
		$records = $result->results;
		$records_to_be_sent = array_merge($prev_records, $records);

		if ($result->next != null) {
			$records_to_be_sent = $this->next_peoples($result->next,
				$records_to_be_sent);
		}

		return $records_to_be_sent;
	}

	public function get_films() {
		$response = $this->client->request('GET', 'https://swapi.co/api/films');
		$result = json_decode($response->getBody()->getContents());
		$records = $result->results;
		return $records;
	}
}
