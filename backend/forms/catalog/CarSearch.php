<?php

namespace backend\forms\catalog;

use core\entities\catalog\car\Car;
use core\entities\catalog\Category;
use core\helpers\CarHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CarSearch extends Model
{
    public $id;
    public $name;

    public $status;
    public $category_id;

    public $price_at;
    public $price_to;

    public $date_from;
    public $date_to;
    public $updated_at;

    public function rules(): array
    {
        return [
            [['id', 'category_id', 'price_at', 'price_to', 'status'], 'integer'],
            [['name'], 'string'],
            [['date_from', 'date_to','updated_at'], 'date', 'format' => 'php:d.m.Y'],
        ];
    }


    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidArgumentException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Car::find()->with('photo', 'category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $dateFormatter = function ($date) {
            if ($date) {
                return (new \DateTime($date))->format('Y-m-d');
            }
        };

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['between', 'price', $this->price_at, $this->price_to])
            ->andFilterWhere(['>=', 'date', $dateFormatter($this->date_from) ? $dateFormatter($this->date_from) . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'date', $dateFormatter($this->date_to) ? $dateFormatter($this->date_to) . ' 23:59:59' : null]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(),
            'id', function (array $category) {
                return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
            });
    }

    public function statusList(): array
    {
        return CarHelper::statusList();
    }
}
