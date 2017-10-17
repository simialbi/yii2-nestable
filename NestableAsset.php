<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * @version 1.0
 */

namespace simialbi\yii2\nestable;
use yii\web\AssetBundle;

/**
 * Nestable bundle for \slatiusa\nestable\Sortable
 *
 * @author Arno Slatius <a.slatius@gmail.com>
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
}