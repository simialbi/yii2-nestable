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
 * @author Arno Slatius <a.slatius@gmail.com>
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class NestableAsset extends AssetBundle {
	public $sourcePath = __DIR__.'/assets';

	public $js = [
		'js/jquery.nestable.js'
	];

	public $css = [
		'css/nestable.min.css'
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}