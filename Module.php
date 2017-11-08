<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable;

class Module extends \simialbi\yii2\base\Module {
	/**
	 * @var string the namespace that controller classes are in.
	 * This namespace will be used to load controller classes by prepending it to the controller
	 * class name.
	 *
	 * If not set, it will use the `controllers` sub-namespace under the namespace of this module.
	 * For example, if the namespace of this module is `foo\bar`, then the default
	 * controller namespace would be `foo\bar\controllers`.
	 *
	 * See also the [guide section on autoloading](guide:concept-autoloading) to learn more about
	 * defining namespaces and how classes are loaded.
	 */
	public $controllerNamespace = 'simialbi\yii2\nestable\controllers';

	/**
	 * @var string the default route of this module. Defaults to `default`.
	 * The route may consist of child module ID, controller ID, and/or action ID.
	 * For example, `help`, `post/create`, `admin/post/create`.
	 * If action ID is not given, it will take the default value as specified in
	 * [[Controller::defaultAction]].
	 */
	public $defaultRoute = 'move';

	/**
	 * @var boolean determines if nodes can become root elements
	 */
	public $rootable = true;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();

		$this->registerTranslations();
	}
}