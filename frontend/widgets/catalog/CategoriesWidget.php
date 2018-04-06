<?php

namespace frontend\widgets\Shop;

use shop\entities\Shop\Category;
use shop\readModels\Shop\CategoryReadRepository;
use shop\readModels\Shop\views\CategoryView;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\VarDumper;

class CategoriesWidget extends Widget
{
    /** @var Category|null */
    public $active;

    private $categories;

    public function __construct(CategoryReadRepository $categories, $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;
    }

    public function run(): string
    {
        $parents = [];
        $children = [];
        $parentId = 0;
        foreach ($this->categories->getTreeAllWithSubs() as $sub) {
            if ($sub->category->depth == 1) {
                $parents[] = $sub;
                $parentId = $sub->category->id;
            } else {
                $children[$parentId][] = $sub;
            }
        }

        return Html::tag('ul', implode(PHP_EOL, array_map(function (CategoryView $view) use ($children) {

            $active = $this->active && ($this->active->id == $view->category->id || $this->active->isChildOf($view->category));

            $childrenLi = '';
            foreach ($children[$view->category->id] as $child) {
                $childrenA = Html::a(Html::encode($child->category->name) . ' (' . $view->count . ')',
                    ['/shop/catalog/category', 'id' => $child->category->id]
                );
                $childrenLi .= Html::tag('li', $childrenA);
            }

            $childrenUl = Html::tag('ul', $childrenLi,
                [
                    'id' => 'collapseOne' . $view->category->id,
                    'class' => 'panel-collapse collapse list-category'
                ]);


            $result = Html::a(Html::encode($view->category->name) . ' (' . $view->count . ')',
                ['/shop/catalog/category', 'id' => $view->category->id],
                ['class' => $active ? 'active' : '']
            );
            $content = Html::a('<i class="fa fa-plus"></i>',
                null,
                [
                    'data-toggle' => 'collapse',
                    'data-parent' => '#accordion',
                    'data-target' => '#collapseOne' . $view->category->id,
                ]
            );
            $result .= Html::tag('span', $content, [
                'class' => 'head',
            ]);


            $result .= $childrenUl;

            $res = Html::tag('li', $result, [
                'class' => 'haschild',
            ]);
            return $res;

        }, $parents)), [
            'id' => 'accordion',
            'class' => 'box-category box-panel',
        ]);

    }
}