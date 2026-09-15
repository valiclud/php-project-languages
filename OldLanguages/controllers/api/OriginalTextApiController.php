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

	public function list(?int $page = 1): void
	{
		$page = $page ?? 1;

		$paginationResult = $this->paginationTable->find('controller_name', 'apiOriginalTextController');
		$pagination = (!empty($paginationResult) && isset($paginationResult[0])) ? $paginationResult[0] : null;

		if ($pagination === null) {
			$message = 'Record column controller_name -> "apiOriginalTextController" is not stored in database table pagination. Default value pagination=5 is to be set.';

			$pagination = Pagination::default();
			error_log($message);
		}

		$limit = $pagination->results;
		$offset = ($page - 1) * $limit;
		$originalTexts = $this->originalTextTable->findAll($limit, $offset);
		$totaloriginalTexts = $this->originalTextTable->total();
		$totalPages = $limit > 0 ? (int)ceil($totaloriginalTexts / $limit) : 1;

		$sanitizedRows = array_map(function ($row) {
			$data = (array)$row;

			return [
				'idorigtext' => (int)($data['id'] ?? 0),
				'origtextauthor' => htmlspecialchars($data['author_text'] ?? '', ENT_QUOTES, 'UTF-8'),
				'origtexttext' => htmlspecialchars($data['text'] ?? '', ENT_QUOTES, 'UTF-8'),
				'origtexttitle' => htmlspecialchars($data['title'] ?? '', ENT_QUOTES, 'UTF-8'),
				'origtextimage' => htmlspecialchars($data['text_img'] ?? '', ENT_QUOTES, 'UTF-8'),
				'origtextcentury' => (int)($data['century'] ?? 0),
				'origtextdate' => htmlspecialchars($data['insert_date'] ?? '', ENT_QUOTES, 'UTF-8'),
				'hits' => (int)($data['hits'] ?? 0),
				'idplace' => (int)($data['place_id'] ?? 0),
				'idlanguage' => (int)($data['old_language_id'] ?? 0),
				'idauthor' => (int)($data['author_id'] ?? 0)
			];
		}, $originalTexts ?: []);

		$data = array(
			"total" => $totaloriginalTexts,
			"total_pages" => $totalPages,
			"per_page" => $pagination->results,
			"page_number" => $page,
			"data" => $sanitizedRows
		);
		$responseData = json_encode($data);

		$this->sendOutput($responseData, ["Content-Type: application/json", "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"]);
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

	public function post($id = null, $array = null) {}
	// curl.exe -X POST http://localhost/originaltextapi/post -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"origtextauthor\":\"Unknown\",\"origtexttitle\":\"Battle xxxl\",\"origtexttext\":\"And so on...\",\"origtextimage\":\"\",\"origtextcentury\":1,\"idplace\":1,\"idlanguage\":2,\"idauthor\":1}"

	public function postSubmit()
	{
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
			'hits' => ((int)$inputData['hits'] + 1),
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
