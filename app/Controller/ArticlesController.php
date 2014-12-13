<?php
class ArticlesController extends AppController {
	public function lists() {
		$this->response->type('application/json');

		$article_lists = $this->Article->find(
			'list',
			array(
				'order' => array(
					'news_order' => 'desc'
				)
			)
		);

		$article_lists += $this->success('01','Success');

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
