<?php

namespace controllers;

class OriginalTextController
{
	public function __construct(
		private \classes\DatabaseTable $originalTextTable,
		private \classes\DatabaseTable $translatedTextTable,
		private \classes\DatabaseTable $placesTable,
		private \classes\DatabaseTable $languageTable,
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

	public function list()
	{
		$originalTexts = $this->originalTextTable->findAll();
		//echo "<script>console.log('" . json_encode($result) . "');</script>";
		$title = 'Original Text List';
		$totalOriginalTexts = $this->originalTextTable->total();

		return ['template'=>'originaltexts.html.php', 'title' => $title, 'variables' => [
			'totalOriginalTexts' => $totalOriginalTexts,
			'originalTexts' => $originalTexts
		]];
	}

	public function edit($id = null) {
	    if (isset($id)) {
	        $originaltext = $this->originalTextTable->find('id', $id)[0] ?? null;
	    }
	    else {
	    	$originaltext = null;
        }

	    $title = 'Edit Original Text';

	    return ['template' => 'editoriginaltext.html.php',
	        'title' => $title,
	        'variables' => [
	            'originalText' => $originaltext
	        ]
	    ];
	}

	public function editSubmit($id = null) {
		$originaltext = $_POST['originaltext'];
	
		$this->originalTextTable->update($originaltext);

		header('location: /originaltext/list');
	}

	public function save()
	{
		var_dump("666666666666");
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
