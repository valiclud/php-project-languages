<?php

namespace controllers;

use entities\OriginalText;
use entities\Pagination;

class OriginalTextController
{
	public function __construct(
		private \classes\DatabaseTable $placesTable,
		private \classes\DatabaseTable $languageTable,
		private \classes\DatabaseTable $originalTextTable,
		private \classes\DatabaseTable $translatedTextTable,
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
		$this->originalTextTable->delete('id', $id);

		header('location: /originaltext/list');
	}

	public function list(?int $page = 0)
	{
		$pagination = $this->paginationTable->find('controller_name', 'originaltextController')[0];
		if ($pagination == null) {
			$message = 'Record column controller_name -> "originaltextController" is not stored in database table pagination
			default value pagination=5 is to be set.';
			$pagination = Pagination::default();
			error_log($message);
		}

		$limit = $pagination->results;
		$originalTexts = $this->originalTextTable->findAll($limit, ($page - 1) * $limit);
		$totalOriginalTexts = $this->originalTextTable->total();
		$title = 'Original Text List';

		return ['template' => 'originaltexts.html.php', 'title' => $title, 'variables' => [
			'totalOriginalTexts' => $totalOriginalTexts,
			'originalTexts' => $originalTexts,
			'numPages' => ceil($totalOriginalTexts / $limit)
		]];
	}

	public function edit($id = null)
	{
		if (isset($id)) {
			$originaltext = $this->originalTextTable->find('id', $id)[0] ?? null;
		} else {
			$originaltext = null;
		}

		$title = 'Edit Original Text';

		return [
			'template' => 'editoriginaltext.html.php',
			'title' => $title,
			'variables' => [
				'originalText' => $originaltext
			]
		];
	}

	public function editSubmit($id = null)
	{
		$originaltext = $_POST['originaltext'];

		$this->originalTextTable->update($originaltext);

		header('location: /originaltext/list');
	}

	public function save()
	{
		$title = 'Save New Original Text';

		return [
			'template' => 'saveoriginaltext.html.php',
			'title' => $title,
			'variables' => [
				'originalText' => new OriginalText($this->placesTable, $this->languageTable)
			]
		];
	}

	public function saveSubmit()
	{
		$originaltext = $_POST['originaltext'];
		if ((isset($_POST['originaltext']) && $_POST['originaltext'] != "") ||
			$originaltext['place_id'] == "0" || $originaltext['old_language_id'] == "0"
		) {
			$originaltext['insert_date'] = date_create()->format('Y-m-d');
			$originaltext['hits'] = 1;

			$originaltext['text_img'] = file_get_contents($_FILES['myfile']['tmp_name']);

			$this->originalTextTable->save($originaltext);

			header('location: /originaltext/list');
		} else {
			$title = 'Save New Original Text';

			return [
				'template' => 'saveoriginaltext.html.php',
				'title' => $title,
				'variables' => [
					'originalText' => new OriginalText($this->placesTable, $this->languageTable)
				]
			];
		}
	}

}
