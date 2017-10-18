<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * @version 1.0
 */

namespace simialbi\yii2\nestable;
use yii\web\AssetBundle;

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