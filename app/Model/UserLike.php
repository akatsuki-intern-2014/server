<?php
class UserLike extends AppModel {
	public $belongsTo = array(
		'Article',
		'User'
	);
}
