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
		private \classes\Authentication $authentication
	) {
		error_log("konstruktor OriginalTextApiController");
	}

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
		$data = array("total" => $totaloriginalTexts, "total_pages" => $totalPages, "per_page" => $pagination->results, 
			"page_number" => $page, "data" => $originalTexts);
		$responseData = json_encode($data);
	
		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK", "Access-Control-Allow-Origin: *"));

		return null;
	}

	public function get($id = null)
	{
		if (isset($id) && $id != "") {
			$originalText = $this->originalTextTable->find('id', $id)[0] ?? null;
		} else {
			$originalText = new OriginalText($this->placesTable, $this->languageTable);
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
			"page_number" => 3, "data" => $originalTexts);
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

	public function postSubmit() {
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
		error_log(json_encode($post));
		error_log($post['origtextauthor']);
	/*	
		$origText = OriginalText::default($this->placesTable, $this->languageTable);
		$origText->setAuthor($post['origtextauthor']);
		$origText->setText($post['origtexttext']);
		$origText->setTitle($post['origtexttitle']);
		$origText->setTextimg($post['origtextimage']);
		$origText->setCentury($post['origtextcentury']);
		$origText->setInsertdate(date_create()->format('Y-m-d'));
		$origText->setHits(1);
*/
		$origText = array();
		$origText['author_text'] = $post['origtextauthor'];
		$origText['text'] = $post['origtexttext'];
		$origText['title'] = $post['origtexttitle'];
		$origText['text_img'] = $post['origtextimage'];
		$origText['century'] = $post['origtextcentury'];
		$origText['insert_date'] = date_create()->format('Y-m-d');
		$origText['hits'] = 1;
		$origText['place_id'] = $post['idplace'];
		$origText['old_language_id'] = $post['idlanguage'];

		$this->originalTextTable->save($origText);
	
		return null;

	}

}