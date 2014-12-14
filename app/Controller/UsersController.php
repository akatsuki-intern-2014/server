<?php
class UsersController extends AppController {

	var $uses = array('User','UserLike');

	public function add() {
		$user['User']['username'] = hash('md5',date('YmdHis'));
	}

	public function like($like_username = null) {
		$user_likes = $this->UserLike->find(
			'all',
			array(
#				'conditions' => array(
#					'user_id' => $like_username
#				),
				'order' => array(
					'created' => 'desc'
				)
			)
		);
		$user_likes += $this->success('05','Success');
		$this->set('result',$user_likes);
		
	}
}
