<?php
class RankingsController extends AppController {

	var $uses = array('Article');

	public function all() {
		$lists = $this->Article->find(
			'all',
			array(
				'order' => array(
					'Like.value' => 'desc'
				)
			)
		);

		$lists += $this->success('03','Success');
		$this->set('result',$lists);
		
	}

	public function category($category_id = null) {
		if ($category_id =! null) {
			$lists = $this->Article->find(
				'all',
				array(
					'order' => array(
						'Like.value' => 'desc'
					),
					'conditions' => array(
						'Article.category_id' => $category_id
					)
				)
			);
			$lists += $this->success('04','Success');
		} else {
			$lists = $this->error('-04','Undefined Category_id');
		}
		$this->set('result',$lists);
	}
}
