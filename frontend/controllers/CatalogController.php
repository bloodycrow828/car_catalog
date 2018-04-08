<?php

namespace frontend\controllers;

use core\readModels\Catalog\CarReadRepository;
use core\readModels\Catalog\CategoryReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $cars;
    private $categories;

    public function __construct(
        $id,
        $module,
        CarReadRepository $cars,
        CategoryReadRepository $categories,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->cars = $cars;
        $this->categories = $categories;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex(): string
    {
        $dataProvider = $this->cars->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function actionCategory($id): string
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->cars->getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return mixed
     */
    public function actionSearch()
    {
        $form = new SearchForm();
        $form->load(\Yii::$app->request->queryParams);
        $form->validate();

        $dataProvider = $this->cars->search($form);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $form,
        ]);
    }


    public function actionCar($slug)
    {
        if (!$car = $this->cars->findBySlug($slug)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->layout = 'blank';

        return $this->render('car', [
            'car' => $car,
        ]);
    }
}