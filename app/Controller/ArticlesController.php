<?php
class ArticlesController extends AppController {

	var $uses = array('Article','Category');

	public function lists($category_id = null) {
		$this->response->type('application/json');

		if ($caterogy_id =! null) {
			
			$article_lists = $this->Article->find(
				'list',
				array(
					'conditions' => array(
						'Article.category_id' => $category_id
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
		$this->response->type('application/json');
		if ($article_id =! null) {
			$article_detail = $this->Article->find(
				'first',
				array(
					'conditions' => array(
						'article_id' => $article_id
					)	
				)
			);
			$article_detail += $this->success('01','Success');
		} else {
			$article_detail = $this->eror('-01','Error');
		}
		$this->set('result',$article_detail);
	}

	public function category() {
		$this->response->type('application/json');
		$category_list['Category'] = $this->Category->find('list');
		$category_list += $this->success('02','Success');
		$this->set('result',$category_list);
	}
}
