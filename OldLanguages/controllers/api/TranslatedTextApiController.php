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
		private \classes\Authentication $authentication
	) {
	}

	public function delete($id = null)
	{
		$this->translatedTextTable->delete('id', $id);

		return null;
	}

	public function list(?int $page = 1)
	{
		$pagination = $this->paginationTable->find('controller_name', 'apitranslatedtextController')[0];
		if ($pagination == null) {
			$message = 'Record column controller_name -> "apitranslatedtextController" is not stored in database table pagination
			default value pagination=5 is to be set.';
			$pagination = Pagination::default();
			error_log($message);
		}

		$limit = $pagination->results;
		$offset = ($page - 1) * $limit;
		$translatedTexts = $this->translatedTextTable->findAll($limit, $offset);
		$totalTranslatedTexts = $this->translatedTextTable->total();
		$totalPages = ceil($totalTranslatedTexts / $pagination->results);
		$data = array("total" => $totalTranslatedTexts, "total_pages" => $totalPages, "per_page" => $pagination->results, 
			"page_number" => $page, "data" => $translatedTexts);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));

		return null;
	}

	public function get($id = null)
	{
		if (isset($id) && $id != "") {
			$translatedText = $this->translatedTextTable->find('id', $id)[0] ?? null;
		} else {
			$translatedText = new TranslatedText($this->originalTextTable);
		}

		$data = array("data" => $translatedText);
		$responseData = json_encode($data);
		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));

		return null;
	}

}
