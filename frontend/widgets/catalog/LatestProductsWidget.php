<?php

namespace frontend\widgets\Shop;

use shop\readModels\Shop\ProductReadRepository;
use yii\base\Widget;

class LatestProductsWidget extends Widget
{
    public $limit;

    private $repository;

    public function __construct(ProductReadRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->render('latest_products', [
            //'products' => $this->repository->getFeatured($this->limit)
        ]);
    }
}