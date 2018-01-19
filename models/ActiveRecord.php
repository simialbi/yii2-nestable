<?php
/**
 * @package yii2-nestable
 * @author Simon Karlen <simi.albi@gmail.com>
 * @version 1.0
 */

namespace simialbi\yii2\nestable\models;

/**
 * Class ActiveRecord
 * @package simialbi\yii2\nestable\models
 *
 * @method boolean makeRoot(boolean $runValidation = true, array $attributes = null) Creates the root node if the active record is new or moves it as the root node.
 * @method boolean prependTo(\yii\db\ActiveRecord $node, boolean $runValidation = true, array $attributes = null) Creates a node as the first child of the target node if the active record is new or moves it as the first child of the target node.
 * @method boolean appendTo(\yii\db\ActiveRecord $node, boolean $runValidation = true, array $attributes = null) Creates a node as the last child of the target node if the active record is new or moves it as the last child of the target node.
 * @method boolean insertBefore(\yii\db\ActiveRecord $node, boolean $runValidation = true, array $attributes = null) Creates a node as the previous sibling of the target node if the active record is new or moves it as the previous sibling of the target node.
 * @method boolean insertAfter(\yii\db\ActiveRecord $node, boolean $runValidation = true, array $attributes = null) Creates a node as the next sibling of the target node if the active record is new or moves it as the next sibling of the target node.
 * @method integer|false deleteWithChildren() Deletes a node and its children.
 * @method \yii\db\ActiveQuery parents(integer $depth = null) Gets the parents of the node.
 * @method \yii\db\ActiveQuery children(integer $depth = null) Gets the children of the node.
 * @method \yii\db\ActiveQuery leaves() Gets the leaves of the node.
 * @method \yii\db\ActiveQuery prev() Gets the previous sibling of the node.
 * @method \yii\db\ActiveQuery next() Gets the next sibling of the node.
 * @method boolean isRoot() Determines whether the node is root.
 * @method boolean isChildOf(\yii\db\ActiveRecord $node) Determines whether the node is child of the parent node.
 * @method boolean isLeaf() Determines whether the node is leaf.
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord {
	/**
	 * Move model after another model of this sortable scope.
	 *
	 * @param static $model
	 *
	 * @return boolean
	 */
	abstract public function moveAfter($model);

	/**
	 * Move model as first of this sortable scope.
	 *
	 * @return boolean
	 */
	abstract public function moveAsFirst();
}