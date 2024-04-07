<?php

namespace controllers;

use entities\Pagination;

class PaginationController
{
	public function __construct(
		private \classes\DatabaseTable $paginationTable
	) {
	}

	public function home()
	{
		$title = 'Internet Old Languages Database';

		return ['template' => 'home.html.php', 'title' => $title, 'variables' => []];
	}

	public function delete($id = null)
	{
		$this->paginationTable->delete('id', $id);

		header('location: /pagination/list');
	}

	public function list()
	{
		$paginations = $this->paginationTable->findAll();
		$title = 'Pagination List';

		return ['template' => 'paginations.html.php', 'title' => $title, 'variables' => [
			'paginations' => $paginations
		]];
	}

	public function edit($id = null)
	{
		if (isset($id)) {
			$pagination = $this->paginationTable->find('id', $id)[0] ?? null;
		} else {
			$pagination = null;
		}

		$title = 'Edit Pagination';

		return [
			'template' => 'editpagination.html.php',
			'title' => $title,
			'variables' => [
				'pagination' => $pagination
			]
		];
	}

	public function editSubmit($id = null)
	{
		$pagination = $_POST['pagination'];

		$this->paginationTable->update($pagination);

		header('location: /pagination/list');
	}

	public function save()
	{
		$title = 'Save New Pagination Record';

		return [
			'template' => 'savepagination.html.php',
			'title' => $title,
			'variables' => [
				'pagination' => new Pagination()
			]
		];
	}

	public function saveSubmit()
	{
		$pagination = $_POST['pagination'];
		if ((isset($_POST['pagination']) && $_POST['pagination'] != "")
			) {
			$this->paginationTable->save($pagination);

			header('location: /pagination/list');
		} else {
			$title = 'Save New Pagination';

			return [
				'template' => 'savepagination.html.php',
				'title' => $title,
				'variables' => [
					'pagination' => new Pagination()
				]
			];
		}
	}

}
