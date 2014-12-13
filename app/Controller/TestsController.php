<?php
class TestsController extends AppController {
	public function get() {
		// Set Content Header
		$this->response->type('application/json');

		if ($this->request->is('get')) {
			$result = $this->success('00','This get test page!!');
		} else {
			$result = $this->error('00','This get test page!!');
		}
		$this->set('result',$result);
	}
	
	public function post() {
		$this->response->type('application/json');

		if ($this->request->is('post') ) {
			$result = $this->success('00','This post test page!!');
		} else {
			$result = $this->error('00','This post test page!!');
		}

		$this->set('result',$result);
	}


}
