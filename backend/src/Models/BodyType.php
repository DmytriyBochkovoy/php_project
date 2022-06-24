<?php

namespace It20Academy\App\Models;

use It20Academy\App\Core\Db;
use PDO;

class BodyType extends Model
{
    public int $id;
    public string $name;
    public string $createdAt;
    public string $updatedAt;
    protected string $table = 'body_types';

    public static function all(): array
    {
        $dbh = (new Db())->getHandler();
        $statement = $dbh->query('SELECT cars.*, body_types.name as body_type FROM `cars` JOIN `body_types` ON cars.body_type_id = body_types.id');
        $initialCars = $statement->fetchAll();

//        dump($initialCars);

        return array_map(function ($initialCar) {
            $car = new self; // $post = new Post;
            $car->setId($initialCar['id']);
            $car->setName($initialCar['name']);
            $car->setConsumption($initialCar['consumption']);
            $car->setCapacity($initialCar['capacity']);
            $car->setMadeCar($initialCar['made_car']);
            $car->setPrice($initialCar['price']);
            $car->setCreatedAt($initialCar['created_at']);
            $car->setUpdatedAt($initialCar['updated_at']);
            $car->setBodyTypeId($initialCar['body_type_id']);

            return $car;
        }, $initialCars);
    }

    public static function findId($id): array
    {
            $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare('SELECT * FROM `posts` WHERE id=:id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch();
//        dd($post);
        return $post;

    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}