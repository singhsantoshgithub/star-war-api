<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\People;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Page1Controller extends Controller {

	private $client;

	public function __construct() {
		$this->client = new Client();
	}

	public function index() {
		return view('page1');
	}

	public function get_people(Request $request) {

		try {
			$response = $this->client->request('GET', $request->api_url);
			$result = $response->getBody()->getContents();

		} catch (\Exception $e) {
			$result = json_encode([
				"error" => true,
				"code" => 404,
				"detail" => "Not Found",
			]);
		}

		return $result;

	}

	public function get_film(Request $request) {
		try {
			$response = $this->client->request('GET', $request->api_url);
			$result = $response->getBody()->getContents();

		} catch (\Exception $e) {
			$result = json_encode([
				"error" => true,
				"code" => 404,
				"detail" => "Not Found",
			]);
		}

		return $result;
	}

	public function save_people(Request $request) {

		try {

			$response = $this->client->request('GET', $request->api_url);
			$result_json = $response->getBody()->getContents();
			$result = json_decode($result_json);

			$records = People::where('url', $result->url)->count();
			if ($records == 1) {
				People::where('url', $result->url)->update([
					'name' => $result->name,
					'url' => $result->url,
					'json_dump' => $result_json,
				]);
				//people updated event
				return response()->json(['message' => 'People Updated']);
			} else if ($records == 0) {
				People::create([
					'name' => $result->name,
					'url' => $result->url,
					'json_dump' => $result_json,
				]);
				//people created event
				return response()->json(['message' => 'People Created']);
			}

		} catch (\Exception $e) {
			return response()->json([
				"error" => true,
				"code" => 404,
				"detail" => "Not Found",
			]);
		}

	}

	public function save_film(Request $request) {

		try {

			$response = $this->client->request('GET', $request->api_url);
			$result_json = $response->getBody()->getContents();
			$result = json_decode($result_json);

			$records = Film::where('url', $result->url)->count();
			if ($records == 1) {
				Film::where('url', $result->url)->update([
					'name' => $result->title,
					'url' => $result->url,
					'json_dump' => $result_json,
				]);
				//people updated event
				return response()->json(['message' => 'Film Updated']);
			} else if ($records == 0) {
				Film::create([
					'name' => $result->title,
					'url' => $result->url,
					'json_dump' => $result_json,
				]);
				//people created event
				return response()->json(['message' => 'Film Created']);
			}

		} catch (\Exception $e) {
			return response()->json([
				"error" => true,
				"code" => 404,
				"detail" => "Not Found",
			]);
		}

	}
}
