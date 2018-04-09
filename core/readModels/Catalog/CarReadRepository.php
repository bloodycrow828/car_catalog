<?php

namespace core\readModels\Catalog;

use core\entities\catalog\car\Car;
use core\entities\catalog\Category;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class CarReadRepository
{

    public function getAllByRange(int $offset, int $limit): array
    {
        return Car::find()->alias('p')->active('p')->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    /**
     * @return iterable|Car[]
     */
    public function getAllIterator(): iterable
    {
        return Car::find()->alias('p')->active('p')->with('photo', 'brand')->each();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Car::find()->alias('p')->active('p')->with('photo');
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Car::find()->alias('p')->active('p')->with('photo', 'category');
        $ids = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['p.category_id' => $ids], ['ca.category_id' => $ids]]);
        $query->groupBy('p.id');
        return $this->getProvider($query);
    }

    public function findBySlug($slug): ?Car
    {
        return Car::find()->active()->andWhere(['url' => $slug])->one();
    }

    public function find($id): ?Car
    {
        return Car::find()->active()->andWhere(['id' => $id])->one();
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['p.id' => SORT_ASC],
                        'desc' => ['p.id' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['p.name' => SORT_ASC],
                        'desc' => ['p.name' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['p.price' => SORT_ASC],
                        'desc' => ['p.price' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [15, 100],
            ]
        ]);
    }


}