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
    public $category_id;
    public $status;

    public function rules(): array
    {
        return [
            [['id', 'category_id', 'status'], 'integer'],
            [['name'], 'safe'],
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

        $query->andFilterWhere(['like', 'name', $this->name]);

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
