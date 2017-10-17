<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * @version 1.0
 */

namespace simialbi\yii2\nestable\widgets;

use simialbi\yii2\nestable\NestableAsset;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

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
	 * Normal list
	 */
	const TYPE_LIST = 'list';
	/**
	 * List with handle
	 */
	const TYPE_WITH_HANDLE = 'list-handle';

	/**
	 * @var string the type of the sortable widget
	 * Defaults to Nestable::TYPE_WITH_HANDLE
	 */
	public $type = self::TYPE_WITH_HANDLE;

	/**
	 * @var string, the handle label, this is not HTML encoded
	 */
	public $handleLabel = '<div class="dd-handle dd3-handle">&nbsp;</div>';

	/**
	 * @var array the HTML attributes to be applied to list.
	 * This will be overridden by the [[options]] property within [[$items]].
	 */
	public $listOptions = [];

	/**
	 * @var array the HTML attributes to be applied to all items.
	 * This will be overridden by the [[options]] property within [[$items]].
	 */
	public $itemOptions = [];

	/**
	 * @var array the sortable items configuration for rendering elements within the sortable
	 * list / grid. You can set the following properties:
	 * - id: integer, the id of the item. This will get returned on change
	 * - content: string, the list item content (this is not HTML encoded)
	 * - disabled: bool, whether the list item is disabled
	 * - options: array, the HTML attributes for the list item.
	 * - contentOptions: array, the HTML attributes for the content
	 * - children: array, with item children
	 */
	public $items = [];

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
	 * @var \yii\db\ActiveQuery that holds the data for the tree to show.
	 */
	public $query;

	/**
	 * @var array options to be used with the model on list preparation. Supporten properties:
	 * - name: {string|function}, attribute name for the item title or unnamed function($model) that returns a
	 *         string for each item.
	 */
	public $modelOptions = [];

	/**
	 * @var array the HTML attributes for the title tag.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $options = [];

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

		if (null != $this->query) {
			$this->items = $this->prepareItems($this->query);
		}
		if (count($this->items) === 0) {
			echo Html::tag('div', '', ['class' => 'dd-empty']);
		}
	}

	/**
	 * Runs the widget
	 *
	 * @return string|void
	 */
	public function run() {
		if (count($this->items) > 0) {
			echo Html::beginTag('ol', ['class' => 'dd-list']);
			echo $this->renderItems();
			echo Html::endTag('ol');
		}
		echo Html::endTag('div');

		$this->registerPlugin();
	}

	/**
	 * Render the list items for the sortable widget
	 *
	 * @param array|null $_items
	 *
	 * @return string
	 */
	protected function renderItems($_items = null) {
		$_items = is_null($_items) ? $this->items : $_items;
		$items  = '';
		$dataid = 0;
		foreach ($_items as $item) {
			$options = ArrayHelper::getValue($item, 'options', ['class' => 'dd-item dd3-item']);
			$options = ArrayHelper::merge($this->itemOptions, $options);
			$dataId  = ArrayHelper::getValue($item, 'id', $dataid++);
			$options = ArrayHelper::merge($options, ['data-id' => $dataId]);

			$contentOptions = ArrayHelper::getValue($item, 'contentOptions', ['class' => 'dd3-content']);
			$content        = $this->handleLabel;
			$content        .= Html::tag('div', ArrayHelper::getValue($item, 'content', ''), $contentOptions);

			$children = ArrayHelper::getValue($item, 'children', []);
			if (!empty($children)) {
				// recursive rendering children items
				$content .= Html::beginTag('ol', ['class' => 'dd-list']);
				$content .= $this->renderItems($children);
				$content .= Html::endTag('ol');
			}

			$items .= Html::tag('li', $content, $options).PHP_EOL;
		}

		return $items;
	}

	/**
	 * Registers the nestable javascript assets and builds the required js for the widget
	 */
	protected function registerPlugin() {
		$id   = $this->options['id'];
		$view = $this->getView();
		NestableAsset::register($view);
		$js = [
			"jQuery('#$id').nestable({$this->getClientOptions()});"
		];
		$view->registerJs(implode("\n", $js), $view::POS_READY);
	}

	/**
	 * Get client options as json encoded string
	 *
	 * @return string
	 */
	protected function getClientOptions() {
		return Json::encode($this->clientOptions);
	}


	/**
	 * Prepare item array from active query
	 *
	 * @param $activeQuery \yii\db\ActiveQuery
	 *
	 * @return array
	 */
	protected function prepareItems($activeQuery) {
		if (!($activeQuery instanceof \yii\db\ActiveQuery)) {
			return [];
		}

		$this->clientOptions['modelClass'] = $activeQuery->modelClass;

		$items = [];
		foreach ($activeQuery->all() as $model) {
			/* @var $model \simialbi\yii2\nestable\models\ActiveRecord */
			$name = ArrayHelper::getValue($this->modelOptions, 'name', 'name');
			if (is_array($name)) {
				if (is_callable($name[0])) {
					$func = array_shift($name);
					array_push($name, ['model' => $model]);
					$content = call_user_func_array($func, $name);
				} else {
					$value = [];
					foreach ($name as $key) {
						if ($model->hasAttribute($key)) {
							$value[] = $model->$key;
						} else {
							$value[] = $key;
						}
					}
					$content = implode(' ', $value);
				}
			} else {
				$content = $model->$name;
			}
			$items[] = [
				'id'       => $model->getPrimaryKey(),
				'content'  => $content,
				'children' => $this->prepareItems($model->children(1)),
			];
		}

		return $items;
	}
}
