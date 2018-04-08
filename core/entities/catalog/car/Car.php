<?php

namespace core\entities\catalog\car;

use core\dataModels\CarData;
use yii\web\UploadedFile;


class Car extends CarData
{
    public const STATUS_DEACTIVATE = 0;
    public const STATUS_ACTIVE = 1;

    public static function create($categoryId, $name, $slug): self
    {
        $car = new static();
        $car->category_id = $categoryId;
        $car->name = $name;
        $car->url = $slug;
        $car->status = self::STATUS_DEACTIVATE;
        $car->created_at = time();
        $car->updated_at = time();
        return $car;
    }

    public function setPrice($new): void
    {
        $this->price = $new;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->url = $slug;
        $this->updated_at = time();
    }

    public function changeMainCategory($categoryId): void
    {
        $this->category_id = $categoryId;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Car is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if ($this->isDeactivate()) {
            throw new \DomainException('Car is already deactivate.');
        }
        $this->status = self::STATUS_DEACTIVATE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isDeactivate(): bool
    {
        return $this->status === self::STATUS_DEACTIVATE;
    }

    // Categories
    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }

    // Photo
    public function addPhoto(UploadedFile $file): void
    {
        $photo = Photo::create($file);
        $this->updatePhoto($photo);
    }

    public function removePhoto(): void
    {
        if ($photo = $this->photo) {
            $photo->delete();
            return;
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function updatePhoto(Photo $photo = null)
    {
        $this->photo = $photo;
    }
}