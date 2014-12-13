<?php
class ArticlesController extends AppController {

	var $uses = array('Article','Category','Like');

	public function lists($category_id = null) {
		$this->response->type('application/json');

		if ($caterogy_id =! null) {
			
			$article_lists = $this->Article->find(
				'all',
				array(
					'conditions' => array(
						'Article.category_id' => $category_id
					),
					'fields' => array(
						'Article.id',
						'Article.title',
						'Article.created',
						'Like.value'
					)
				)
			);

			foreach($article_lists as $article_list) {
				$article_list['Article']['image_url'] = WWW_ROOT;
			}

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
						'Article.id' => $article_id
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

	public function like($article_id) {
		if ($article_id =! null) {
			if ($like = $this->Like->findByArticleId($article_id)) {
				$this->Like->updateAll(
					array(
						'Like.value' => '`Like`.`value` + 1',
						'Like.modified' => "'".date('Y-m-d H:i:s')."'"
					),
					array(
						'Like.id' => $like['Like']['id'],
						'Like.article_id' => $article_id
					)
				);
			} else {
				$data = array(
					'Like' => array(
						'value' => 1,
						'article_id' => $article_id,
					)
				);
 				$this->Like->save($data);
			}
			$result = $this->success(01,'Success');
		} else {
			$result = $this->error(-01,'Errro');
		}
		$this->set('result',$result);
	}
}
