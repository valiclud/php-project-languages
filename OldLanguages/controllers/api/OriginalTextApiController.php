<?php

namespace controllers\api;

use entities\OriginalText;
use entities\Pagination;
use controllers\api\BaseApiController;

class OriginalTextApiController extends BaseApiController
{
	public function __construct(
		private \classes\DatabaseTable $placesTable,
		private \classes\DatabaseTable $languageTable,
		private \classes\DatabaseTable $originalTextTable,
		private \classes\DatabaseTable $paginationTable,
		private \classes\Authentication $authentication,
		private \classes\DatabaseTable $authorsTable
	) {}

	public function delete($id = null)
	{
		$this->originalTextTable->delete('id', $id);

		return null;
	}

	public function list(?int $page = 1)
	{
		$pagination = $this->paginationTable->find('controller_name', 'apiOriginalTextController')[0];
		if ($pagination == null) {
			$message = 'Record column controller_name -> "apiOriginalTextController" is not stored in database table pagination
			default value pagination=5 is to be set.';
			$pagination = Pagination::default();
			error_log($message);
		}

		$limit = $pagination->results;
		$offset = ($page - 1) * $limit;
		$originalTexts = $this->originalTextTable->findAll($limit, $offset);
		$totaloriginalTexts = $this->originalTextTable->total();
		$totalPages = ceil($totaloriginalTexts / $pagination->results);
		$data = array(
			"total" => $totaloriginalTexts,
			"total_pages" => $totalPages,
			"per_page" => $pagination->results,
			"page_number" => $page,
			"data" => $originalTexts
		);
		$responseData = json_encode($data);

		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));

		return null;
	}

	public function get($id = null)
	{
		if (isset($id) && $id != "") {
			$originalText = $this->originalTextTable->find('id', $id)[0] ?? null;
		} else {
			$originalText = new OriginalText($this->placesTable, $this->languageTable, $this->authorsTable);
		}

		$data = array("data" => $originalText);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));

		return null;
	}

	public function post($id = null, $array = null)
	{
		// 1. Povolte doménu, ze které běží váš React (Vite)
		header("Access-Control-Allow-Origin: http://localhost:5173");

		// 2. Klíčový krok: Povolte hlavičku Content-Type, kterou požaduje Axios
		header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

		// 3. Povolte metody, které přes API přijímáte
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");

		// 4. Zpracování předběžného dotazu (Preflight/OPTIONS)
		// Prohlížeč se nejdříve zeptá metodou OPTIONS. Pokud přijde, musíme ihned vrátit status 200 a ukončit skript.
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			http_response_code(200);
			exit();
		}
	}
	// curl.exe -X POST http://localhost/originaltextapi/post -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"origtextauthor\":\"Unknown\",\"origtexttitle\":\"Battle xxxl\",\"origtexttext\":\"And so on...\",\"origtextimage\":\"\",\"origtextcentury\":1,\"idplace\":1,\"idlanguage\":2,\"idauthor\":1}"

	public function postSubmit()
	{
		// 1. Tyto hlavičky musí být odeslány VŽDY – jak pro OPTIONS, tak pro POST/GET
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
		header('Access-Control-Allow-Headers: token, Content-Type, Authorization, X-Requested-With');

		// 2. Ošetření preflight (OPTIONS) požadavku
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('Content-Type: text/plain');
			http_response_code(200); // explicitně řekneme, že preflight je OK
			exit(0);
		}

		// 3. Nastavení pro běžné požadavky (POST, GET atd.)
		header('Content-Type: application/json');

		$post = json_decode(file_get_contents('php://input'), true);
		$requiredFields = [
			'origtextauthor',
			'origtexttext',
			'origtexttitle',
			'origtextimage',
			'origtextcentury',
			'idplace',
			'idlanguage',
			'idauthor'
		];

		if (!is_array($post) || array_diff($requiredFields, array_keys($post))) {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid request body.']);
			return null;
		}

		$originalText = [
			'author_text' => $post['origtextauthor'],
			'text' => $post['origtexttext'],
			'title' => $post['origtexttitle'],
			'text_img' => $post['origtextimage'],
			'century' => (int) $post['origtextcentury'],
			'insert_date' => date_create()->format('Y-m-d'),
			'hits' => 1,
			'place_id' => (int) $post['idplace'],
			'old_language_id' => (int) $post['idlanguage'],
			'author_id' => (int) $post['idauthor']
		];

		$id = $this->originalTextTable->save($originalText);
		http_response_code(201);
		$data = array("data" => $id);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
	}

	// curl.exe -X PUT http://localhost/api/originaltextapi/update -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"idorigtext\":61,\"origtextauthor\":\"Unknown\",\"origtexttitle\":\"Battle xxxl\",\"origtexttext\":\"And so on...\",\"origtextimage\":\"\",\"origtextcentury\":1,\"idplace\":1,\"idlanguage\":2,\"idauthor\":1}"
	public function update($id = null, $array = null)
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: PUT");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		// Ochrana: Povolíme pouze metodu PUT
		if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
			http_response_code(405);
			echo json_encode(["message" => "Metoda není povolena. Použijte PUT."]);
			exit;
		}
		$inputData = json_decode(file_get_contents("php://input"), true);

		// 3. Definice vašich povinných polí
		$requiredFields = [
			'idorigtext',
			'origtextauthor',
			'origtexttitle',
			'origtexttext',
			'origtextcentury',
			'idplace',
			'idlanguage',
			'idauthor'
		];

		if (!isset($inputData['idorigtext'])) {
			http_response_code(400);
			echo json_encode(["message" => "Chyba: Chybí ID záznamu pro aktualizaci."]);
			exit;
		}

		// 4. Validace: Ověření, zda jsou všechna povinná pole přítomna a nejsou prázdná
		$missingFields = [];
		foreach ($requiredFields as $field) {
			if (!isset($inputData[$field]) || trim($inputData[$field]) === '') {
				$missingFields[] = $field;
			}
		}
		if (!empty($missingFields)) {
			http_response_code(400);
			echo json_encode([
				"message" => "Chyba: Neúplná data.",
				"missing_fields" => $missingFields
			]);
			exit;
		}

		$originalText = [
			'id' => (int)$inputData['idorigtext'],
			'author_text' => htmlspecialchars(strip_tags($inputData['origtextauthor'])),
			'title' => htmlspecialchars(strip_tags($inputData['origtexttitle'])),
			'text' => htmlspecialchars(strip_tags($inputData['origtexttext'])),
			'text_img' => isset($inputData['origtextimage']) ? htmlspecialchars(strip_tags($inputData['origtextimage'])) : null,
			'century' => htmlspecialchars(strip_tags($inputData['origtextcentury'])),
			'insert_date' => date_create()->format('Y-m-d'),
			'hits' => 2,
			'place_id' => (int)$inputData['idplace'],
			'old_language_id' => (int) $inputData['idlanguage'],
			'author_id' => (int) $inputData['idauthor']
		];

		$this->originalTextTable->update($originalText);
		http_response_code(201);
		$data = (int)$inputData['idorigtext'];
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
	}
}
