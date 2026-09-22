<?php

namespace controllers\api;

use entities\TranslatedText;
use entities\Pagination;
use controllers\api\BaseApiController;

class TranslatedTextApiController extends BaseApiController
{
	public function __construct(
		private \classes\DatabaseTable $translatedTextTable,
		private \classes\DatabaseTable $originalTextTable,
		private \classes\DatabaseTable $paginationTable,
		private \classes\DatabaseTable $authorTable
	) {}

	public function delete($id = null)
	{
		$this->translatedTextTable->delete('id', $id);

		return null;
	}
	// curl.exe http://localhost/api/translatedtextapi/list

	public function list(?int $page = 1)
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
		$translatedTexts = $this->translatedTextTable->findAll($limit, $offset);
		$totalTranslatedTexts = $this->translatedTextTable->total();
		$totalPages = $limit > 0 ? (int)ceil($totalTranslatedTexts / $limit) : 1;

		$sanitizedRows = array_map(function ($row) {
			$data = (array)$row;

			return [
				'idtranstext' => (int)($data['id'] ?? 0),
				'transtexttitle' => htmlspecialchars($data['title'] ?? '', ENT_QUOTES, 'UTF-8'),
				'transtexttext' => htmlspecialchars($data['text'] ?? '', ENT_QUOTES, 'UTF-8'),
				'transtextlanguage' => htmlspecialchars($data['language'] ?? '', ENT_QUOTES, 'UTF-8'),
				'transtextdate' => htmlspecialchars($data['insert_date'] ?? '', ENT_QUOTES, 'UTF-8'),
				'revision' => (int)($data['revision'] ?? 0),
				'idauthor' => (int)($data['author_id'] ?? 0),
				'idorigtext' => (int)($data['original_text_id'] ?? 0)
			];
		}, $translatedTexts ?: []);

		$data = array(
			"total" => $totalTranslatedTexts,
			"total_pages" => $totalPages,
			"per_page" => $pagination->results,
			"page_number" => $page,
			"data" => $sanitizedRows
		);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));

		return null;
	}

	public function get($id = null)
	{
		if (isset($id) && $id != "") {
			$translatedText = $this->translatedTextTable->find('id', $id)[0] ?? null;
		} else {
			$translatedText = new TranslatedText($this->originalTextTable, $this->authorTable);
		}

		$data = array("data" => $translatedText);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json'));

		return null;
	}

	//curl.exe -X POST http://localhost/api/translatedtextapi/post -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"transtexttitle\":\"Unknown\",\"transtexttext\":\"Battle xxxl\",\"transtextlanguage\":\"And so on...\",\"revision\":1,\"idauthor\":1,\"idorigtext\":43}"
	public function postSubmit()
	{
		$post = json_decode(file_get_contents('php://input'), true);
		$requiredFields = [
			'transtexttitle',
			'transtexttext',
			'transtextlanguage',
			'revision',
			'idauthor',
			'idorigtext'
		];

		if (!is_array($post) || array_diff($requiredFields, array_keys($post))) {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid request body.']);
			return null;
		}

		$translatedText = [
			'title' => $post['transtexttitle'],
			'text' => $post['transtexttext'],
			'language' => $post['transtextlanguage'],
			'insert_date' => date_create()->format('Y-m-d'),
			'revision' => (int) $post['revision'],
			'author_id' => (int) $post['idauthor'],
			'original_text_id' => (int) $post['idorigtext']
		];

		$id = $this->translatedTextTable->save($translatedText);
		http_response_code(201);
		$data = array("data" => $id);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
	}

	//curl.exe -X PUT http://localhost/api/translatedtextapi/update -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"idtranstext\":8,\"transtexttitle\":\"Unknown\",\"transtexttext\":\"Battle xxxl\",\"transtextlanguage\":\"And so on...\",\"revision\":1,\"idauthor\":1,\"idorigtext\":43}"
	public function update($id = null, $array = null)
	{
		$inputData = json_decode(file_get_contents("php://input"), true);

		// 3. Definice vašich povinných polí
		$requiredFields = [
			'idtranstext',
			'transtexttitle',
			'transtexttext',
			'transtextlanguage',
			'revision',
			'idauthor',
			'idorigtext'
		];

		if (!isset($inputData['idtranstext'])) {
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

		$translatedText = [
			'id' => (int)$inputData['idtranstext'],
			'title' => htmlspecialchars($inputData['transtexttitle'] ?? '', ENT_QUOTES, 'UTF-8'),
			'text' => htmlspecialchars($inputData['transtexttext'] ?? '', ENT_QUOTES, 'UTF-8'),
			'language' => htmlspecialchars($inputData['transtextlanguage'] ?? '', ENT_QUOTES, 'UTF-8'),
			'insert_date' => date_create()->format('Y-m-d'),
			'revision' => (int)($inputData['revision'] ?? 0),
			'author_id' => (int)($inputData['idauthor'] ?? 0),
			'original_text_id' => (int)($inputData['idorigtext'] ?? 0)
		];
		$this->translatedTextTable->update($translatedText);
		http_response_code(201);
		$data = (int)$inputData['idtranstext'];
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
	}
}
