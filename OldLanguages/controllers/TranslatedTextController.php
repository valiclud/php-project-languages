<?php

namespace controllers;

use entities\TranslatedText;
use entities\Pagination;

class TranslatedTextController
{
	public function __construct(
		private \classes\DatabaseTable $translatedTextTable,
        private \classes\DatabaseTable $originalTextTable,
		private \classes\DatabaseTable $paginationTable,
		private \classes\Authentication $authentication
	) {
	}

	public function home()
	{
		$title = 'Internet Old Languages Database';

		return ['template' => 'home.html.php', 'title' => $title, 'variables' => []];
	}

	public function delete($id = null)
	{
		$this->translatedTextTable->delete('id', $id);

		header('location: /translatedtext/list');
	}

	public function list(?int $page = 0)
	{
		$pagination = $this->paginationTable->find('controller_name', 'translatedtextController')[0];
		if ($pagination == null) {
			$message = 'Record column controller_name -> "translatedtextController" is not stored in database table pagination
			default value pagination=5 is to be set.';
			$pagination = Pagination::default();
			error_log($message);
		}

		$limit = $pagination->results;
		$translatedTexts = $this->translatedTextTable->findAll($limit, ($page-1)*$limit);
		$title = 'Translated Text List';
		$totalTranslatedTexts = $this->translatedTextTable->total();

		return ['template' => 'translatedtexts.html.php', 'title' => $title, 'variables' => [
			'totalTranslatedTexts' => $totalTranslatedTexts,
			'translatedTexts' => $translatedTexts,
			'numPages' => ceil($totalTranslatedTexts / $limit)
		]];
	}

	public function edit($id = null)
	{
		if (isset($id)) {
			$translatedText = $this->translatedTextTable->find('id', $id)[0] ?? null;
		} else {
			$translatedText = new TranslatedText($this->originalTextTable);
		}
		$title = 'Edit Translated Text';

		return [
			'template' => 'edittranslatedtext.html.php',
			'title' => $title,
			'variables' => [
				'translatedText' => $translatedText
			]
		];
	}

	public function editSubmit($id = null)
	{
		$translatedText = $_POST['translatedtext'];

		$this->translatedTextTable->update($translatedText);

		header('location: /translatedtext/list');
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
