<?php
/**
 * Akastuki Internship 2014 
 * 
 * @copyright  Copyright (c) Yuta Mizui 2014 Allright received.
 * @link http://www.yutam.tk
 * @package       app.Controller
 */

/**
 * Article Controller 
 *
 * @package app.Controller 
 */
class ArticlesController extends AppController {

	/**
	 * uses property
	 * 
	 * Use DatabaseName
	 */
	var $uses = array('Article','Category','Like','Comment','UserLike');

	/**
	 * lists method
	 *
	 * @param integer $category_id CategpryId
	 * @return void
	 */
	public function lists($category_id = null) {

		// Set response type
		$this->response->type('application/json');

		if ($caterogy_id =! null) {

			// Get article list
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

			// Set image Path and Like value converte
			foreach($article_lists as $key => $article_list) {
				$article_lists[$key]['Article']['image_url'] 
				= Router::fullbaseUrl().DS."server/img/Articles/".$article_list['Article']['id'].".jpg";
				
				if ($article_list['Like']['value'] == null) {
					$article_lists[$key]['Like']['value'] = 0;
				}
			}

			// set success message and status code
			$article_lists += $this->success('01','Success');
		} else {

			// set error message and status code
			$article_lists = $this->error('01','Error');
		}

		$this->set('result',$article_lists);
	}

	/**
	 * detail method
	 *
	 * @param integer $article_id ArticleID
	 * @return void
	 */
	public function detail($article_id = null) {

		// Set response type 
		$this->response->type('application/json');
		if ($id =! null) {

			// Get article data 
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

	/**
	 * category method
	 *
	 * @return void
	 */
	public function category() {

		// Set response type 
		$this->response->type('application/json');

		// Get category list
		$category_list['Category'] = $this->Category->find('list');

		// Set success message 
		$category_list += $this->success('02','Success');
		$this->set('result',$category_list);
	}

	/**
	 * like method
	 *
	 * @param integer $article_like_id ArticleID
	 * @return void
	 */
	public function	like($article_like_id = null) {

		// Set response type
		$this->response->type('application/json');
		if ($article_id =! null) {

			// Get Like Artcile list
			$like_detail = $this->Like->findByArticleId($article_like_id);

			// increment 
			$like_detail['Like']['value']++;

			// Save data
			$this->Like->save($like_detail);

			// User like 
			$user_like = array(
				'user_id' => 1,
				'article_id' => $article_like_id
			);

			// Save UserLike 
			$this->UserLike->save($user_like);
			$result = $this->success(01,'Success');
		} else {
			$result = $this->error(-01,'Errro');
		}
		$this->set('result',$result);
	}
	
	/**
	 * comment method
	 *
	 * @return void
	 */
	public function comment() {

		// Set response type
		$this->response->type('application/json');

		// Accept POST request only
		if ( $this->request->is('post')  ) {

			// parse json to array
			$post_data = json_decode($this->request->input(),true);

			// Generate save data 
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
