<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable\widgets;

use simialbi\yii2\widgets\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Create nestable lists using drag & drop for Yii 2.0.
 * Based on nestedSortable plugin.
 *
 * @author Simon Karlen <simi.albi@gmail.com>
 * @since 1.0
 */
class Nestable extends Widget {
	/**
	 * @var array the HTML attributes for the container tag.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $options = [];
	/**
	 * @var array list of sortable items. Each item can be a string representing the item content
	 * or an array of the following structure:
	 *
	 * ~~~
	 * [
	 *     'content' => 'item content',
	 *     // the HTML attributes of the item container tag. This will overwrite "itemOptions".
	 *     'options' => [],
	 * ]
	 * ~~~
	 */
	public $items = [];
	/**
	 * @var array list of HTML attributes for the item container tags. This will be overwritten
	 * by the "options" set in individual [[items]]. The following special options are recognized:
	 *
	 * - tag: string, defaults to "li", the tag name of the item container tags.
	 *
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $itemOptions = [];
	/**
	 * @var array client options
	 * @see also https://github.com/dbushell/Nestable#configuration
	 */
	public $clientOptions = [];

	/**
	 * Initializes the widget
	 * @throws InvalidConfigException
	 */
	public function init() {
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		if (!isset($this->clientOptions['toleranceElement'])) {
			throw new InvalidConfigException("Client option 'toleranceElement' must be set");
		}
		if (!isset($this->clientOptions['listType'])) {
			$this->clientOptions['listType'] = ArrayHelper::getValue($this->options, 'tag', 'ul');
		}

		parent::init();
	}

	/**
	 * Renders the widget.
	 * @throws InvalidConfigException
	 */
	public function run() {
		$options = $this->options;
		$tag     = ArrayHelper::remove($options, 'tag', 'ul');
		$content = Html::beginTag($tag, $options) . "\n";
		$content .= $this->renderItems($this->items) . "\n";
		$content .= Html::endTag($tag) . "\n";
		$this->registerPlugin('nestedSortable');

		return $content;
	}

	/**
	 * Renders nestable items
	 *
	 * @param array $items list of sortable items. Each item can be a string representing the item content
	 * or an array (see class property [[items]])
	 *
	 * @return string the rendering result.
	 * @see items
	 * @throws InvalidConfigException .
	 */
	public function renderItems(array $items) {
		$listOptions   = $this->options;
		$listTag       = ArrayHelper::remove($listOptions, 'tag', 'ul');
		$renderedItems = [];
		if (isset($listOptions['id'])) {
			unset($listOptions['id']);
		}
		foreach ($items as $item) {
			$options  = $this->itemOptions;
			$tag      = ArrayHelper::remove($options, 'tag', 'li');
			$subItems = ArrayHelper::remove($item, 'items', []);
			if (is_array($item)) {
				if (!isset($item['content'])) {
					throw new InvalidConfigException("The 'content' option is required.");
				}
				$options     = array_merge($options, ArrayHelper::getValue($item, 'options', []));
				$listOptions = array_merge($listOptions, ArrayHelper::getValue($item, 'listOptions', []));
				$tag         = ArrayHelper::remove($options, 'tag', $tag);
				$content     = Html::beginTag($tag, $options);
				$content     .= $item['content'];
				if (!empty($subItems)) {
					$content .= Html::beginTag($listTag, $listOptions) . "\n";
					$content .= $this->renderItems($subItems);
					$content .= Html::endTag($listTag) . "\n";
				}
				$content .= Html::endTag($tag);
			} else {
				$content = Html::beginTag($tag, $options);
				$content .= $item;
				if (!empty($subItems)) {
					$content .= Html::beginTag($listTag, $listOptions) . "\n";
					$content .= $this->renderItems($subItems);
					$content .= Html::endTag($listTag) . "\n";
				}
				$content .= Html::endTag($tag);
			}
			$renderedItems[] = $content;
		}

		return implode("\n", $renderedItems);
	}
}
