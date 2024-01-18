<?php

class OriginalTextController
{
	/*
	private $placesTable;
    private $originalTextTable;
    private $languageTable;
*/
	public function __construct(
		private DatabaseTable $originalTextTable,
		private DatabaseTable $translatedTextTable,
		private DatabaseTable $placesTable,
		private DatabaseTable $languageTable
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

	public function list()
	{
		$result = $this->originalTextTable->findAll();
		//echo "<script>console.log('" . json_encode($result) . "');</script>";

		$originalTexts = [];
		foreach ($result as $originalText) {
			$place = $this->placesTable->find('id', $originalText['place_id'])[0];
			$language = $this->languageTable->find('id', $originalText['old_language_id'])[0];
			$translatedText = $this->translatedTextTable->find('original_text_id', $originalText['id'])[0];
			$originalTexts[] = [
				'id' => $originalText['id'],
				'text' => $originalText['text'],
				'insert_date' => $originalText['insert_date'],
				'title' => $originalText['title'],
				'place' => $place['country'],
				'old_languages' => $language['old_language'],
				'translatedText' => $translatedText['text']
			];
		}

		$title = 'Original Text List';
		$totalOriginalTexts = $this->originalTextTable->total();

		return ['template'=>'originaltexts.html.php', 'title' => $title, 'variables' => [
			'totalOriginalTexts' => $totalOriginalTexts,
			'originalTexts' => $originalTexts
		]];
	}

	public function edit($id = null)
	{
		
		if (isset($_POST['originalText']) && $_POST['originalText'] != "") {
			$originalText['text'] = $_POST['originalText'];
			$originalText['author'] = 'aaaa';
			$originalText['title'] = 'bbbb';
			$originalText['text_img'] = null;
			$originalText['century'] = '1';
			$originalText['insert_date'] = date_create()->format('Y-m-d');
			$originalText['hits'] = 1;
			$originalText['place_id'] = $_POST['place'];
			$originalText['old_language_id'] = $_POST['language'];

			if (isset($id)) {
				$originalText['id'] = $id;
				$originalText['old_language_id'] = $_POST['language'];
				$originalText['place_id'] = $_POST['place'];
				$this->originalTextTable->update($originalText);
				
				header('location: /originaltext/list');
			}

		} else {
			if (isset($id)) {
				$originalText = $this->originalTextTable->find('id', $id)[0] ?? null;
				$languages = $this->languageTable->findAll();
				$places = $this->placesTable->findAll();
				$originalText['languages'] = $languages;
				$originalText['places'] = $places;
			} else {
				$originalText = null;
			}

			$title = 'Edit Original Text';

			return ['template' => 'editoriginaltext.html.php',
						 'title' => $title,
						  'variables' => [
								'originalText' => $originalText ?? null
						  ]];
		}
	}

	public function save()
	{
		if (isset($_POST['originalText']) && $_POST['originalText'] != "") {
			$originalText['text'] = $_POST['originalText'];
			$originalText['author'] = 'aaaa';
			$originalText['title'] = 'bbbb';
			$originalText['text_img'] = null;
			$originalText['century'] = '1';
			$originalText['insert_date'] = date_create()->format('Y-m-d');
			$originalText['hits'] = 1;
			$originalText['place_id'] = $_POST['place'];
			$originalText['old_language_id'] = $_POST['language'];
			$lastId = $this->originalTextTable->save($originalText);

			$translatedText['text'] = $_POST['translatedText'];
			$translatedText['original_text_id'] = $lastId;
			$translatedText['author'] = 'ccc';
			$translatedText['title'] = 'bbb';
			$translatedText['language'] = 'Egyptian';
			$translatedText['insert_date'] = date_create()->format('Y-m-d');
			$translatedText['revision'] = '0';
			$this->translatedTextTable->save($translatedText);
			header('location: /originaltext/list');
		} else {
			$languages = $this->languageTable->findAll();
			$places = $this->placesTable->findAll();
			$originalText['languages'] = $languages;
			$originalText['places'] = $places;

			$title = 'Save New Original Text';

			return ['template' => 'editoriginaltext.html.php',
			'title' => $title,
			 'variables' => [
				   'originalText' => $originalText ?? null
			 ]];
		}
	}
}
