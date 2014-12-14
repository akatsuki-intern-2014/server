<?php
class ArticlesController extends AppController {

	var $uses = array('Article','Category','Like','Comment','UserLike');

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

			foreach($article_lists as $key => $article_list) {
				$article_lists[$key]['Article']['image_url'] 
				= Router::fullbaseUrl().DS."server/img/Articles/".$article_list['Article']['id'].".jpg";
				
				if ($article_list['Like']['value'] == null) {
					$article_lists[$key]['Like']['value'] = 0;
				}
			}

			$article_lists += $this->success('01','Success');
		} else {
			
			$article_lists = $this->error('01','Error');
		}

		$this->set('result',$article_lists);
	}

	public function detail($article_id = null) {
		$this->response->type('application/json');
		if ($id =! null) {
			$article_detail = $this->Article->findById($article_id);
			if ($article_detail['Like']['value'] == null) { 
				$article_detail['Like']['value'] = 0;
			}
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

	public function like($like_article_id = null) {
		$this->response->type('application/json');
		if ($like_article_id =! null) {
			$like = $this->Like->findByArticleId($like_article_id);
			$this->UserLike->save($like);
			$result = $this->success(01,'Success');
		} else {
			$result = $this->error(-01,'Errro');
		}
		$this->set('result',$result);
	}

	public function cooment() {
		$this->response->type('application/json');
		if ( $this->request->is('post')  ) {
			$post_data = json_decode($this->request->input(),true);
			$save_data = array(
				'Comment' => array(
					'article_id' => $post_data['article_id'],
					'body' => $post_data['body']
				)
			);
			if ($this->Comment->save($save_data)) {
				$result = $this->success('00','Success');
			} else {
				$result = $this->error('-00','Error');
			}
		} else {
			$result = $this->error('-01','Error');
		}
		$this->set('result',$result);
	}
}
