<?php

namespace controllers\api;

use entities\TranslatedText;
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

		header('location: /translatedtext/list');
	}

	public function list(?int $page = 0)
	{
		$pagination = $this->paginationTable->find('controller_name', 'translatedtextController')[0];
		$limit = $pagination->results;
		$translatedTexts = $this->translatedTextTable->findAll($limit, ($page - 1) * $limit);
		$title = 'Translated Text List';
		$totalTranslatedTexts = $this->translatedTextTable->total();

		$responseData = json_encode($translatedTexts);
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

		$responseData = json_encode($translatedText);
		$this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));

		$title = 'Edit Translated Text';

		return null;
	}
	public function save()
	{
		$title = 'Save New Translated Text';

		return [
			'template' => 'savetranslatedtext.html.php',
			'title' => $title,
			'variables' => [
				'translatedtext' => new TranslatedText($this->originalTextTable)
			]
		];
	}

	public function saveSubmit()
	{
		$translatedtext = $_POST['translatedtext'];
		if ((isset($_POST['translatedtext']) && $_POST['translatedtext'] != "")) {
			$translatedtext['insert_date'] = date_create()->format('Y-m-d');
			$translatedtext['revision'] = 0;

			$this->translatedTextTable->save($translatedtext);

			header('location: /translatedtext/list');
		} else {
			$title = 'Save New Translated Text';

			return [
				'template' => 'savetranslatedtext.html.php',
				'title' => $title,
				'variables' => [
					'originalText' => new TranslatedText($this->originalTextTable)
				]
			];
		}
	}
}
