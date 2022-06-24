<?php

namespace It20Academy\App\Controllers;

use It20Academy\App\Core\Db;
use It20Academy\App\Core\Request;
use It20Academy\App\Core\Resource;
use It20Academy\App\Core\View;
use It20Academy\App\Core\Storage;
use It20Academy\App\Models\Authors;
use It20Academy\App\Models\Category;
use It20Academy\App\Models\FuilType;
use It20Academy\App\Models\Model;
use It20Academy\App\Models\Post;
use It20Academy\App\Models\Car;
use It20Academy\App\Models\Statuses;
use It20Academy\App\Models\Filters;
use It20Academy\App\Models\Products;
use It20Academy\App\Resources\CarResource;
use It20Academy\App\Service\QueryBuilder;
use PDO;

class CarsController
{
    private array $errors = [];

    public function index()
    {
        $cars = Car::all();

        dump(CarResource::collectionToJson($cars));

        echo View::render('cars-index', compact('cars'));
    }

    public function apiIndex()
    {
        $cars = Car::all();

        echo json_encode($cars);
    }

    public function api()
    {
        $cars = Car::all();

        echo CarResource::collectionToJson($cars);
    }

    public function create()
    {
        $cars = Car::all();

        $errors = $this->errors;

        echo View::render('cars-create', compact('cars'));
    }

    public function store()
    {
        $request = new Request();

        $request->validate([
            'name' => ['required'],
            'capacity' => ['required'],
            'consumption' => ['required'],
            'made_car' => ['required'],
            'power' => ['required'],
            'body_type_id' => ['required'],
            'price' => ['required'],
            'shift_box_id' => ['required']
        ]);

        if ($request->isErrorsNotEmpty()) {
            echo json_encode($request->getErrors());
            die();
        }

        $data = $request->only([
            'name',
            'capacity',
            'consumption',
            'made_car',
            'power',
            'body_type_id',
            'price',
            'shift_box_id',
        ]);

        $fuelTypeId = $request->input('fuel_type_id');

        $queryBuilder = new QueryBuilder();
        $queryBuilder->insert()->into('cars', $data);

        $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare($queryBuilder->getQuery());

        $stmt->execute();

        $queryBuilder->reset();
        $queryBuilder->select('MAX(id) as id')->from('cars');
        $car = $dbh->query($queryBuilder->getQuery())->fetchObject();
        $carId = $car->id;

        $fileHandler = new Storage();

        $nameInputAvatar = 'image';
        $nameInputSlider = 'fileMulti';
        $fileHandler->filesHandler($_FILES, $carId, $nameInputAvatar, $nameInputSlider);

        $carFuelType = [
            'car_id' => $carId,
            'fuel_type_id' => $fuelTypeId,
        ];

        $queryBuilder->reset();

        $queryBuilder->insert()->into('car_fuel_types', $carFuelType);
        $stmt = $dbh->prepare($queryBuilder->getQuery());

        $stmt->execute();

        header('Location: /cars');

        exit();
    }

    public function show()
    {
        $carId = $this->getIdFromUrl();

        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('cars.*')->from('cars')->where('id', '=', "{$carId}");

        $dbh = (new Db())->getHandler();
        $car = $dbh->query($queryBuilder->getQuery())->fetchObject();

        $queryBuilder->reset();
        $queryBuilder->select('fuel_types.*')
            ->from('fuel_types')
            ->join('car_fuel_types', 'car_fuel_types.fuel_type_id', '=', 'fuel_types.id')
            ->where('car_fuel_types.car_id', '=', "{$carId}");

        $fuelType = $dbh->query($queryBuilder->getQuery())->fetchObject();

        $queryBuilder->reset();
        $queryBuilder->select('shift_boxes.*')
            ->from('shift_boxes')
            ->join('cars', 'cars.shift_box_id', '=', 'shift_boxes.id')
            ->where('cars.id', '=', "{$carId}");

        $shiftBox = $dbh->query($queryBuilder->getQuery())->fetchObject();

        $queryBuilder->reset();
        $queryBuilder->select('body_types.*')
            ->from('body_types')
            ->join('cars', 'cars.body_type_id', '=', 'body_types.id')
            ->where('cars.id', '=', "{$carId}");

        $bodyType = $dbh->query($queryBuilder->getQuery())->fetchObject();

        $queryBuilder->reset();
        $queryBuilder->select('files.*')
            ->from('files')
            ->where('files.car_id', '=', "{$carId}");

        $files = $dbh->query($queryBuilder->getQuery())->fetchAll();

        echo View::render('cars-show', compact('car', 'fuelType', 'shiftBox', 'bodyType', 'files'));
    }

    public function showApi()
    {
        $carId = $this->getIdFromUrl();

        echo CarResource::toJson((new Car)->find($carId));
    }

    public function update()
    {
        $id = $this->getIdFromUrl();

        $request = new Request();
        $title = $_POST ['title'] ?? null;
        $author = $_POST['author'] ?? null;
        $status = $_POST['status'] ?? null;
        $category = $_POST['category'] ?? null;
        $img = $_POST['img'] ?? null;
        $content = $_POST['content'] ?? null;

        if ($request->required($title) == false) {
            $this->errors['title'][] = 'Не заполнен title';
        }
        if ($request->required($author) == false) {
            $this->errors['author'][] = 'Не заполнен author';
        }
        if ($request->required($status) == false) {
            $this->errors['status'][] = 'Не заполнен status';
        }
        if ($request->required($category) == false) {
            $this->errors['category'][] = 'Не заполнен category';
        }
        if ($request->required($img) == false) {
            $this->errors['img'][] = 'Не заполнен img';
        }
        if ($request->required($content) == false) {
            $this->errors['content'][] = 'Не заполнен content';
        }
        if (count($this->errors)) {
            $this->show();
            die();
        }

        $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare('UPDATE `posts` SET title= :title, author_id= :author, status_id =:status, category_id = :category, img = :img, content = :content WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->bindParam(':img', $img, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        $stmt->execute();
        $this->index();
    }

    public function delete()
    {
        $id = $this->getIdFromUrl();
        $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare('DELETE FROM `posts` WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->table();
    }

    public function table()
    {
        $posts = Post::all();
        $categories = Category::allCategories();
        $authors = Authors::allAuthors();
        $statuses = Statuses::allStatuses();

        echo json_encode($posts);

//        echo View::render('posts-table', compact('posts', 'authors', 'statuses', 'categories'));
    }

    public function filters()
    {
        $id = $this->getIdFromUrl();
        $filters = Filters::allFilters($id);;
        echo json_encode($filters);
    }

    public function products()
    {
        $rest_json = file_get_contents("php://input");
        $_POST = json_decode($rest_json, true);
        $id = $this->getIdFromUrl();
        $filters = $_POST['filters'] ?? null;
        $price = $_POST['price'] ?? null;
        $products = Products::allProducts($id, $filters, $price);

        echo json_encode($products);
    }

    public function read()
    {
        $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare('SELECT * FROM `posts`');

        $stmt->execute();
        $this->index();
    }

    /**
     * @return mixed|string
     */
    public function getIdFromUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("/", $url);
        $id = $url[count($url) - 1];

        return $id;
    }
}