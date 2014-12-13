<?php
class ArticlesController extends AppController {
	public function lists($category_id = null) {
		$this->response->type('application/json');

		if ($caterogy_id != null) {
			
			$article_lists = $this->Article->find(
				'list',
				array(
					'order' => array(
						'category_id' => $category_id
					)
				)
			);

			$article_lists += $this->success('01','Success');
		} else {
			
			$article_lists = $this->error('01','Error');
		}

		$this->set('result',$article_lists);
	}

	public function detail($article_id = null) {
		$article_detail = $this->Article->find(
			'first',
			array(
				'conditions' => array(
					'article_id' => $article_id
				)	
			)
		);
	}
}
