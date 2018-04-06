<?php

namespace core\entities\catalog\car;

use core\dataModels\CarData;
use core\entities\Meta;
use yii\web\UploadedFile;


class Car extends CarData
{
    public const STATUS_DEACTIVATE = 0;
    public const STATUS_ACTIVE = 1;

    public static function create($categoryId, $name, Meta $meta): self
    {
        $car = new static();
        $car->category_id = $categoryId;
        $car->name = $name;
        $car->status = self::STATUS_DEACTIVATE;
        $car->created_at = time();
        $car->meta = $meta;
        return $car;
    }

    public function setPrice($new): void
    {
        $this->price = $new;
    }

    public function edit($name, Meta $meta): void
    {
        $this->name = $name;
        $this->meta = $meta;
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

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Car is already deactivate.');
        }
        $this->status = self::STATUS_DEACTIVATE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DEACTIVATE;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->name;
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
        $photos = $this->photo;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

}