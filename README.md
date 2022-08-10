# yii2-nestable

Yii 2.0 implementation of nested set behavior using jquery.nestable plugin based on
nestedSortable jQuery plugin implementation.
* [nestedSortable jQuery plugin](https://github.com/ilikenwf/nestedSortable) 
* [Nested Sets Behavior](https://github.com/creocoder/yii2-nested-sets) for Yii 2

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require simialbi/yii2-nestable "~3.0"
```

or add

```
"simialbi/yii2-nestable": "~3.0"
```

to the ```require``` section of your `composer.json` file.

## Usage

Make sure you've attached the NestedSetsBehavior (creocoder/yii2-nested-sets) correctly to your model.

And then render the widget in your view. An advanced example could look like this:

```php
<?php
use simialbi\yii2\nestable\widgets\Nestable;
use yii\helpers\Url;
use yii\web\JsExpression;

echo Nestable::widget([
    'items' => [
        [
            'content' => '<div><a href="#test">My Item</a><span class="handle"></span></div>',
            'options' => ['class' => 'list-group-item'],
            'listOptions' => ['class' => 'list-group'],
            'items' => [
                [
                    'content' => '<div><a href="#testChild">My Child Item</a><span class="handle"></span></div>',
                    'options' => ['class' => 'list-group-item']
                ]
            ]
        ], 
        [
            'content' => '<div><a href="#test2">My Item 2</a><span class="handle"></span></div>',
            'options' => ['class' => 'list-group-item'],
            'listOptions' => ['class' => 'list-group']
        ]
    ],
    'clientOptions' => [
        'expandOnHover' => 700,
        'forcePlaceholderSize' => true,
        'handle' => '.handle',
        'isTree' => true,
        'items' => 'li',
        'placeholder' => 'placeholder',
        'startCollapsed' => true,
        'toleranceElement' => '> div',
        // this js event will be called on change order of list
        'relocate' => new JsExpression('function (evt, ui) {
            var context = null;
            var method = \'root\';
            var parent = ui.item.parent(\'ul\').parent(\'.list-group-item\');
            
            if (ui.item.prev(\'.list-group-item\').length) {
                if (parent.length) {
                    method = \'after\';
                }
                context = ui.item.prev(\'.list-group-item\').data(\'id\');
            } else if (ui.item.next(\'.list-group-item\').length) {
                if (parent.length) {
                    method = \'before\';
                }
                context = ui.item.next(\'.list-group-item\').data(\'id\');
            } else if (parent.length) {
                method = \'prepend\';
                context = ui.item.parent(\'ul\').parent(\'.list-group-item\').data(\'id\');
            }
            
            jQuery.ajax({
                url: \''.Url::to(['site/my']).'/\' + method,
                data: {
                    id: ui.item.data(\'id\'),
                    context: context
                }
            });
        }')
    ]
]);
?>
```

Your controller should then look like this:
```php
<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * This controller provides move actions
 */
class MyController extends Controller {
    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'root'    => [
                'class'      => 'simialbi\yii2\nestable\actions\RootAction',
                'modelClass' => 'simialbi\yii2\nestable\models\ActiveRecord'
            ],
            'after'   => [
                'class'      => 'simialbi\yii2\nestable\actions\AfterAction',
                'modelClass' => 'simialbi\yii2\nestable\models\ActiveRecord'
            ],
            'before'  => [
                'class'      => 'simialbi\yii2\nestable\actions\BeforeAction',
                'modelClass' => 'simialbi\yii2\nestable\models\ActiveRecord'
            ],
            'prepend' => [
                'class'      => 'simialbi\yii2\nestable\actions\PrependAction',
                'modelClass' => 'simialbi\yii2\nestable\models\ActiveRecord'
            ],
            'append'  => [
                'class'      => 'simialbi\yii2\nestable\actions\AppendAction',
                'modelClass' => 'simialbi\yii2\nestable\models\ActiveRecord'
            ]
        ];
    }
}
```

## License

**yii2-nestable** is released under MIT license. See bundled [LICENSE](LICENSE) for details.
