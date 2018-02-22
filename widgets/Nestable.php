<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable\widgets;

use simialbi\yii2\widgets\Widget;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Create nestable lists using drag & drop for Yii 2.0.
 * Based on jquery.nestable.js plugin.
 *
 * @author Arno Slatius <a.slatius@gmail.com>
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class Nestable extends Widget {
	/**
	 * @var array the HTML attributes for the title tag.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $options = [];

	/**
	 * @var string the URL to send the callback to. Defaults to current controller / actionNodeMove which
	 * can be provided by \slatiusa\nestable\nestableNodeMoveAction by registering that as an action in the
	 * controller rendering the Widget.
	 * ```
	 * public function actions() {
	 *    return [
	 *        'nodeMove' => [
	 *            'class' => 'slatiusa\nestable\NestableNodeMoveAction',
	 *        ],
	 *    ];
	 * }
	 * ```
	 * Defaults to [current controller/nodeMove] if not set.
	 */
	public $url;

	/**
	 * @var array client options
	 * @see also https://github.com/dbushell/Nestable#configuration
	 */
	public $clientOptions = [];

	/**
	 * Initializes the widget
	 */
	public function init() {
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		if (null != $this->url) {
			$this->clientOptions['url'] = $this->url;
		} else {
			$this->clientOptions['url'] = Url::to(['/nestable/move']);
		}

		parent::init();

		Html::addCssClass($this->options, 'dd');
		echo Html::beginTag('div', $this->options);
	}

	/**
	 * Runs the widget
	 *
	 * @return string|void
	 */
	public function run() {
		echo Html::endTag('div');

		$this->registerPlugin();
	}
}
