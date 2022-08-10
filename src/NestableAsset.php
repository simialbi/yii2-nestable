<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable;

use simialbi\yii2\web\AssetBundle;

/**
 * Nestable bundle
 *
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class NestableAsset extends AssetBundle {
	/**
	 * {@inheritdoc}
	 */
	public $js = [
		'js/jquery.mjs.nestedSortable.js'
	];

	/**
	 * {@inheritdoc}
	 */
	public $depends = [
		'yii\jui\JuiAsset'
	];
}