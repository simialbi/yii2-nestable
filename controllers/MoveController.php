<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable\controllers;

use creocoder\nestedsets\NestedSetsBehavior;
use yii\base\InvalidConfigException;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;
use Yii;

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
				'class'   => ContentNegotiator::className(),
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
				'className' => NestedSetsBehavior::className(),
				'model'     => $model::className()
			]));
		}

		if (($model->isRoot() || $model->makeRoot()) && $context) {
			$model->moveAfter($context);
		}

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
				'className' => NestedSetsBehavior::className(),
				'model'     => $model::className()
			]));
		}

		$model->insertAfter($context);

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
				'className' => NestedSetsBehavior::className(),
				'model'     => $model::className()
			]));
		}

		$model->insertBefore($context);

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
				'className' => NestedSetsBehavior::className(),
				'model'     => $model::className()
			]));
		}

		$model->appendTo($context);

		Yii::$app->response->setStatusCode(204);
	}
}