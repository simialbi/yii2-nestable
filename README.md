# yii2-nestable

Yii 2.0 implementation of nested set behavior using jquery.nestable plugin based on
Arno Slatius implementation.
* [slatiusa/yii2-nestable](https://github.com/ASlatius/yii2-nestable): Arno Slatius implementation
* [nestedSortable jQuery plugin](https://github.com/ilikenwf/nestedSortable) 
* [Nested Sets Behavior](https://github.com/creocoder/yii2-nested-sets) for Yii 2

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require simialbi/yii2-nestable "~1.0"
```

or add

```
"simialbi/yii2-nestable": "~1.0"
```

to the ```require``` section of your `composer.json` file.

## Usage

Make sure you've attached the NestedSetsBehavior (creocoder/yii2-nested-sets) correctly to your model.

And then render the widget in your view;

```php
<?php
use simialbi\yii2\nestable\widgets\Nestable;

echo Nestable::widget([
    'clientEvents' => [
        'change' => 'function(e) {}',
    ],
    'clientOptions' => [
        'maxDepth' => 7,
    ]
]);
?>
```

You can either supply an ActiveQuery object in `query` from which a tree will be built.
You can also supply an item list;
```php
    ...
    'items' => [
        ['content' => 'Item # 1', 'id' => 1],
        ['content' => 'Item # 2', 'id' => 2],
        ['content' => 'Item # 3', 'id' => 3],
        ['content' => 'Item # 4 with children', 'id' => 4, 'children' => [
            ['content' => 'Item # 4.1', 'id' => 5],
            ['content' => 'Item # 4.2', 'id' => 6],
            ['content' => 'Item # 4.3', 'id' => 7],
        ]],
    ],
```

The `modelOptions['name']` should hold an attribute name that will be used to name on the items in the list.
You can alternatively supply an unnamed `function($model)` to build your own content string.

Supply a `pluginEvents['change']` with some JavaScript code to catch the change event fired by jquery.nestable plugin.
The `pluginOptions` accepts all the options for the original jquery.nestable plugin.

## License

**yii2-nestable** is released under MIT license. See bundled [LICENSE](LICENSE) for details.