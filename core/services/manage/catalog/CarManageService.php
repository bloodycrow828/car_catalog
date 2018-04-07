<?php

namespace core\services\manage\catalog;

use core\entities\catalog\car\Car;
use core\forms\manage\catalog\Car\CarCreateForm;
use core\forms\manage\catalog\car\CarEditForm;
use core\forms\manage\catalog\Car\PhotoForm;
use core\forms\manage\catalog\Car\PriceForm;
use core\repositories\catalog\CarRepository;
use core\repositories\catalog\CategoryRepository;
use core\services\common\TransactionManager;


class CarManageService
{
    private $cars;
    private $categories;
    private $transaction;

    public function __construct(
        CarRepository $cars,
        CategoryRepository $categories,
        TransactionManager $transaction
    )
    {
        $this->cars = $cars;
        $this->categories = $categories;
        $this->transaction = $transaction;
    }

    public function create(CarCreateForm $form): Car
    {
        $category = $this->categories->get($form->categories->main);

        $car = Car::create($category->id, $form->name);

        $car->setPrice($form->price->new);
        if ($form->photo->file !== null) {
            $car->addPhoto($form->photo->file);
        }
        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $car->assignCategory($category->id);
        }


        $this->transaction->wrap(function () use ($car) {
            $this->cars->save($car);
        });

        return $car;
    }

    public function edit($id, CarEditForm $form): void
    {
        $car = $this->cars->get($id);
        $category = $this->categories->get($form->categories->main);

        $car->edit($form->name);

        $car->changeMainCategory($category->id);

        $this->transaction->wrap(function () use ($car, $form) {

            $car->revokeCategories();
            $this->cars->save($car);

            foreach ($form->categories->others as $otherId) {
                $category = $this->categories->get($otherId);
                $car->assignCategory($category->id);
            }

            $this->cars->save($car);
        });
    }

    public function changePrice($id, PriceForm $form): void
    {
        $car = $this->cars->get($id);
        $car->setPrice($form->new);
        $this->cars->save($car);
    }

    public function activate($id): void
    {
        $car = $this->cars->get($id);
        $car->activate();
        $this->cars->save($car);
    }

    public function deactivate($id): void
    {
        $car = $this->cars->get($id);
        $car->deactivate();
        $this->cars->save($car);
    }

    public function addPhoto(int $id, PhotoForm $form): void
    {
        $car = $this->cars->get($id);
        $car->addPhoto($form->file);
        $this->cars->save($car);
    }

    public function removePhoto($id): void
    {
        $car = $this->cars->get($id);
        $car->removePhoto();
        $this->cars->save($car);
    }


    public function remove($id): void
    {
        $car = $this->cars->get($id);
        $this->cars->remove($car);
    }
}