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
 * Append node to context node
 *
 * @throws InvalidConfigException
 * @since 3.0
 */
class AppendAction extends Action {
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

		if (!$model->hasMethod('appendTo', true)) {
			throw new InvalidConfigException(Yii::t('simialbi/nestable', 'Model {model} must extend {className}', [
				'className' => \creocoder\nestedsets\NestedSetsBehavior::class,
				'model'     => get_class($model)
			]));
		}

		$model->appendTo($context);

		Yii::$app->response->setStatusCode(204);
	}
}