<?php
class RankingsController extends AppController {

	/**
	 * uses property
	 *
	 * @var array $uses UseDatabaseName
	 */
	var $uses = array('Article');

	/**
	 * all method
	 *
	 *  All ranking API
	 *
	 * @return void
	 */
	public function all() {

		// Set response type
		$this->response->type('application/json');

		// get article ranking 
		$lists = $this->Article->find(
			'all',
			array(
				'order' => array(
					'Like.value' => 'desc'
				),
				'fields' => array(
					'Article.id',
					'Article.title',
					'Article.category_id',
					'Category.name',
					'Like.value'
				)
			)
		);

		// Convert value 
		foreach($lists as $key => $list) {
			$lists[$key]['Comment']['value'] = count($list['Comment']);
			if ($list['Like']['value'] == null) {
				$lists[$key]['Like']['value'] = 0;
			}
		}

		$lists += $this->success('03','Success');
		$this->set('result',$lists);
		
	}

	/**
	 * category method
	 *
	 * Category Ranking API
	 *
	 * @param integer $category_id CategoryID
	 * @return void
	 */
	public function category($category_id = null) {

		// Set response type
		$this->response->type('application/json');

		if ($category_id =! null) {

			// Get Article Ranking
			$lists = $this->Article->find(
				'all',
				array(
					'order' => array(
						'Like.value' => 'desc'
					),
					'conditions' => array(
						'Article.category_id' => $category_id
					),

					'fields' => array(
						'Article.id',
						'Article.title',
						'Article.category_id',
						'Category.name',
						'Like.value'
					)
				)
			);

			// Cnvert Like value
			foreach($lists as $key => $list) {
				$lists[$key]['Commnet']['value'] = count($list['Comment']);
				if ($list['Like']['value'] == null) {
					$lists[$key]['Like']['value'] = 0;
				}
			}		

			$lists += $this->success('04','Success');
		} else {
			$lists = $this->error('-04','Undefined Category_id');
		}
		$this->set('result',$lists);
	}
}
