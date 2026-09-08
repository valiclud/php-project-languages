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

		/*dat do hlavicky:
		Accept: application/json
Access-Control-Allow-Origin: *
Access-Control-Allow-Headers: *
*/
		/*
		echo "User name: ".$_POST['key'];
		echo file_get_contents('php://input');
		echo $_POST;

		$data = json_decode( file_get_contents('php://input') );
		$originalTexts = $this->originalTextTable->findAll(3, 3);
		$totaloriginalTexts = $this->originalTextTable->total();
		$totalPages = ceil($totaloriginalTexts / 3);
		$data = array("total" => $totaloriginalTexts, "total_pages" => $totalPages, "per_page" => 3, 
			"page_number" => 3, "da$origText['place_id'] = $post['idplace'];ta" => $originalTexts);
		$responseData = json_encode($data);

		//$this->sendOutput(null, array('Content-Type: application/json', "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
		$this->sendOutput($responseData, array('Content-Type: application/json',  "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));
      	*/
		$title = 'Edit Original Text';

		return [
			'template' => 'frontend_api/editoriginaltext.html',
			'title' => $title,
			'variables' => [
				'originalText' => null
			]
		];
		/*
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
      
        $this->personGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;$post = json_decode(file_get_contents('php://input'), true);
    $user->username = $post['username'];
    echo json_encode($user);
        */
	}
// curl.exe -X POST http://localhost/originaltextapi/post -H "Content-Type: application/json" -H "Accept: application/json" -d "{\"origtextauthor\":\"Unknown\",\"origtexttitle\":\"Battle xxxl\",\"origtexttext\":\"And so on...\",\"origtextimage\":\"\",\"origtextcentury\":1,\"idplace\":1,\"idlanguage\":2,\"idauthor\":1}"

	public function postSubmit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
			header('Access-Control-Allow-Headers: token, Content-Type');
			header('Content-Type: text/plain');
			die();
		}
		header('Access-Control-Allow-Origin: *');
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
		echo json_encode(['id' => $id]);

		return null;
	}
}
