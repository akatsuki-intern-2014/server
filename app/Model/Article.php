<?php
class Article extends AppModel {
	public $hasMany = array(
		'Comment'
	);

	public $belongsTo = array(
		'Category'
	);

	public $hasOne = array(
		'Like'
	);
}
