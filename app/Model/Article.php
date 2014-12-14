<?php
class Article extends AppModel {
	public $hasMany = array(
		'Comment',
		array(
			'fields' => array(
				'id',
				'body',
				'article_id',
			)
		)
	);

	public $belongsTo = array(
		'Category',
		array(
			'fields' => array(
				'id',
				'name'
			)
		)
	);

	public $hasOne = array(
		'Like',
		array(
			'fields' => array(
				'id',
				'value',
				'article_id'
			)
		)
	);
}
