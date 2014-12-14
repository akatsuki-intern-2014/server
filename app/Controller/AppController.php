<?php
/**
 * Akastuki Internship 2014 Team D 
 *
 * 	manma
 *
 * @copyright  Copyright (c) Yuta Mizui 2014 Allright received.
 * @link http://www.yutam.tk
 * @package       app.Controller
 */

App::uses('Controller', 'Controller');
/**
 * Article Controller
 * 
 * @package app.Controller
 */
class AppController extends Controller {

	/**
	 * compornents 
	 */
	public $components = array(
		'DebugKit.Toolbar',
		'Session',
	);
	
	/**
	 * success method
	 *
	 * @access private
	 * @return array status code and message.
	 */
	protected function success($code = '--', $message = '--') {

		// Generate response code and message
		$status = array(
			'Status' => array(
				'code' => $code,
				'message' => $message,
				'condition' => "OK"
			)
		);
		return $status;
	}
	
	/**
	 * error method 
	 *
	 * @access protected
	 * @return array status code and message.
	 */
	protected function error($code = '--', $message = '--') {
		
		// Generate response code and message
		$status = array(
			'Status' => array(
				'code' => $code,
				'message' => $message,
				'condition' => "NG",
				'meta' => array(
					'url' => $this->request->here,
					'method' => $this->request->method(),
				)
			)
		);
		// If request is post
		if ($this->request->is('post')) {
			$status['Status']['meta']['postData'] = $this->request->input();
		} 
		return $status;
	}

}
