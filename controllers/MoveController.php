<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable\controllers;

use simialbi\yii2\nestable\event\AfterMoveEvent;
use simialbi\yii2\nestable\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

/**
 * Handles movement of nodes
 *
 * @property \simialbi\yii2\nestable\Module $module
 *
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class MoveController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'contentNegotiator' => [
				'class'   => ContentNegotiator::class,
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
					'application/xml'  => Response::FORMAT_XML,
				]
			]
		];
	}

	/**
	 * Make node a root node and move node after node context
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 * @param string $modelClass class name
	 *
	 * @throws InvalidConfigException
	 */
	public function actionRoot($id, $context = null, $modelClass = '') {
		/* @var $modelClass \yii\db\ActiveRecord */
		$model   = $modelClass::findOne($id);
		$context = $modelClass::findOne($context);

		/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */
		/* @var $context \simialbi\yii2\nestable\models\ActiveRecord */

		if (!$model->hasMethod('makeRoot', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		if (($model->isRoot() || $model->makeRoot())) {
			if ($context) {
				$model->moveAfter($context);
			} else {
				$model->moveAsFirst();
			}
		}

		$this->module->trigger(Module::EVENT_AFTER_MOVE, new AfterMoveEvent([
			'operation' => AfterMoveEvent::OPERATION_ROOT,
			'sender'    => $model
		]));

		Yii::$app->response->setStatusCode(204);
	}

	/**
	 * Move node after context node
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 * @param string $modelClass class name
	 *
	 * @throws InvalidConfigException
	 */
	public function actionAfter($id, $context, $modelClass = '') {
		/* @var $modelClass \yii\db\ActiveRecord */
		$model   = $modelClass::findOne($id);
		$context = $modelClass::findOne($context);
		/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */

		if (!$model->hasMethod('insertAfter', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		$model->insertAfter($context);

		$this->module->trigger(Module::EVENT_AFTER_MOVE, new AfterMoveEvent([
			'operation' => AfterMoveEvent::OPERATION_AFTER,
			'sender'    => $model
		]));

		Yii::$app->response->setStatusCode(204);
	}

	/**
	 * Move node before context node
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 * @param string $modelClass class name
	 *
	 * @throws InvalidConfigException
	 */
	public function actionBefore($id, $context, $modelClass = '') {
		/* @var $modelClass \yii\db\ActiveRecord */
		$model   = $modelClass::findOne($id);
		$context = $modelClass::findOne($context);
		/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */

		if (!$model->hasMethod('insertBefore', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		$model->insertBefore($context);

		$this->module->trigger(Module::EVENT_AFTER_MOVE, new AfterMoveEvent([
			'operation' => AfterMoveEvent::OPERATION_BEFORE,
			'sender'    => $model
		]));

		Yii::$app->response->setStatusCode(204);
	}

	/**
	 * Append node to context node
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 * @param string $modelClass class name
	 *
	 * @throws InvalidConfigException
	 */
	public function actionAppend($id, $context, $modelClass = '') {
		/* @var $modelClass \yii\db\ActiveRecord */
		$model   = $modelClass::findOne($id);
		$context = $modelClass::findOne($context);
		/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */

		if (!$model->hasMethod('appendTo', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		$model->appendTo($context);

		$this->module->trigger(Module::EVENT_AFTER_MOVE, new AfterMoveEvent([
			'operation' => AfterMoveEvent::OPERATION_APPEND,
			'sender'    => $model
		]));

		Yii::$app->response->setStatusCode(204);
	}

	/**
	 * Prepend node to context node
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 * @param string $modelClass class name
	 *
	 * @throws InvalidConfigException
	 */
	public function actionPrepend($id, $context, $modelClass = '') {
		/* @var $modelClass \yii\db\ActiveRecord */
		$model   = $modelClass::findOne($id);
		$context = $modelClass::findOne($context);
		/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */

		if (!$model->hasMethod('prependTo', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		$model->prependTo($context);

		$this->module->trigger(Module::EVENT_AFTER_MOVE, new AfterMoveEvent([
			'operation' => AfterMoveEvent::OPERATION_PREPEND,
			'sender'    => $model
		]));

		Yii::$app->response->setStatusCode(204);
	}
}