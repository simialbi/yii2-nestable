<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable;

/**
 * Class Module
 * @package simialbi\yii2\nestable
 */
class Module extends \simialbi\yii2\base\Module {
	/**
	 * @const after move event constant
	 */
	const EVENT_AFTER_MOVE = 'afterMove';

	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'simialbi\yii2\nestable\controllers';

	/**
	 * {@inheritdoc}
	 */
	public $defaultRoute = 'move';

	/**
	 * @var boolean determines if nodes can become root elements
	 */
	public $rootable = true;

	/**
	 * {@inheritdoc}
	 * @throws \ReflectionException
	 */
	public function init() {
		parent::init();

		$this->registerTranslations();
	}
}