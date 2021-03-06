<?php

namespace backend\controllers\catalog;

use backend\forms\catalog\CarSearch;
use core\entities\catalog\car\Car;
use core\forms\manage\catalog\Car\CarCreateForm;
use core\forms\manage\catalog\Car\CarEditForm;
use core\forms\manage\catalog\Car\PhotoForm;
use core\forms\manage\catalog\Car\PriceForm;
use core\services\manage\catalog\CarManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CarController extends Controller
{
    private $service;

    public function __construct($id, $module, CarManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'deactivate' => ['POST'],
                    'delete-photo' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $car = $this->findModel($id);
        
        $photoForm = new PhotoForm();
        if ($photoForm->load(Yii::$app->request->post()) && $photoForm->validate()) {
            try {
                $this->service->addPhoto($car->id, $photoForm);
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'car' => $car,
            'photoForm' => $photoForm,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new CarCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $car = $this->service->create($form);
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $car = $this->findModel($id);

        $form = new CarEditForm($car);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($car->id, $form);
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'car' => $car,
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     * @throws NotFoundHttpException
     */
    public function actionPrice($id)
    {
        $car = $this->findModel($id);

        $form = new PriceForm($car);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changePrice($car->id, $form);
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('price', [
            'model' => $form,
            'car' => $car,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDeactivate($id)
    {
        try {
            $this->service->deactivate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDeletePhoto($id)
    {
        try {
            $this->service->removePhoto($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }


    protected function findModel(int $id): Car
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
