<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace simialbi\yii2\nestable\event;

use yii\base\Event;

/**
 * AfterMoveEvent represents the information available in [[\simialbi\yii2\nestable\Module::EVENT_AFTER_MOVE]]
 *
 * @package simialbi\yii2\nestable\event
 */
class AfterMoveEvent extends Event {
	/**
	 * @const constant defining operation `root`
	 */
	const OPERATION_ROOT = 'root';
	/**
	 * @const constant defining operation `after`
	 */
	const OPERATION_AFTER = 'after';
	/**
	 * @const constant defining operation `before`
	 */
	const OPERATION_BEFORE = 'before';
	/**
	 * @const constant defining operation `append`
	 */
	const OPERATION_APPEND = 'append';
	/**
	 * @const constant defining operation `prepend`
	 */
	const OPERATION_PREPEND = 'prepend';
	/**
	 * @var string Executed operation one of 'root', 'after', 'before', 'append', 'prepend'
	 */
	public $operation = self::OPERATION_ROOT;
	/**
	 * @var \simialbi\yii2\nestable\models\ActiveRecord|null Context model for all events except 'root'
	 */
	public $contextModel = null;
}