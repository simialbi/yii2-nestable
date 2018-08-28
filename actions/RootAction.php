<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace simialbi\yii2\nestable\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

/**
 * Make node a root node and move node after node context
 *
 * @throws InvalidConfigException
 */
class RootAction extends Action {
	/**
	 * @var string class name
	 */
	public $modelClass = '\yii\db\ActiveRecord';

	/**
	 * Executes Action
	 *
	 * @param mixed $id primary key value of node
	 * @param mixed $context primary key value of context node
	 *
	 * @throws InvalidConfigException
	 */
	public function run($id, $context = null) {
		$modelClass = $this->modelClass;
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

		Yii::$app->response->setStatusCode(204);
	}
}