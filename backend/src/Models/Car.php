<?php

namespace It20Academy\App\Models;

use It20Academy\App\Core\Db;
use It20Academy\App\Service\QueryBuilder;
use PDO;

class Car extends Model
{
    public int $id;
    public int $capacity;
    public int $consumption;
    public string $name;
    public string $madeCar;
    public int $power;
    public int $price;
    public string $createdAt;
    public string $updatedAt;
    public int $bodyTypeId;
    protected string $table = 'cars';
    protected array $fillable = ['id', 'capacity', 'consumption', 'name', 'made_car', 'power', 'price'];



    public string $type;
    public string $img;
    public string $description;
    public string $productsCount;

    public static function all(): array
    {
        $dbh = (new Db())->getHandler();
        $statement = $dbh->query('SELECT cars.* FROM `cars`');
        $initialCars = $statement->fetchAll();

        return array_map(function ($initialCar) {
            $car = new self;
            $car->fill($initialCar);
            $car->bodyType();
            $car->shiftBox();
            $car->slides();
            $car->avatar();
            $car->fuilTypes();
            $car->fuilType();

            return $car;
        }, $initialCars);

    }

    public function find ($id) {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select('cars.*')->from('cars')->where('id', '=', "{$id}");

        $dbh = (new Db())->getHandler();
        $data = $dbh->query($queryBuilder->getQuery())->fetchObject();

        $car = new self;
        $car->fill($data);
        $car->bodyType();
        $car->shiftBox();
        $car->slides();
        $car->avatar();
        $car->fuilTypes();
        $car->fuilType();

        return $car;
    }

    public function bodyType() {
        return $this->hasParent(BodyType::class, 'body_type', 'body_type_id');
    }

    public function shiftBox() {
        return $this->hasParent(ShiftBox::class, 'shift_box', 'shift_box_id');
    }

    public function files() {
        return $this->hasMany(File::class, 'files', 'car_id');
    }

    public function avatar() {
        return $this->hasChild(File::class, 'avatar', 'car_id', function (QueryBuilder $queryBuilder) {
            $queryBuilder
                ->and()
                ->where('category', '=', 'avatar');
        });
    }

    public function slides() {
        return $this->hasMany(File::class, 'slides', 'car_id', function (QueryBuilder $queryBuilder) {
            $queryBuilder
                ->and()
                ->where('category', '=', 'slider');
        });
    }

    public function fuilTypes() {
        return $this->toMany(FuilType::class, 'fuilType', 'fuel_types.id', 'fuel_type_id', 'car_id');
    }

    public function fuilType() {
        $value = $this->fuilTypes();

        if (count($value) > 1) {
            $string = "{$value[0]->name} / {$value[1]->name}";
        } else {
            $string = "{$value[0]->name}";
        }

        return $string;
    }

    public static function findId($id): array
    {
            $dbh = (new Db())->getHandler();
        $stmt = $dbh->prepare('SELECT * FROM `posts` WHERE id=:id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch();

        return $post;

    }

    public static function filteredCar()
    {
        $cars = self::all();

        return array_filter($cars, function ($car) {
            if (($car->getStatus() - 1) === 0) {
                return $car;
            }
        });
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

    public function setProductsCount(string $productsCount): void
    {
        $this->productsCount = $productsCount;
    }

    public function getProductsCount(): string
    {
        return $this->productsCount;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
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

    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    public function getImg(): string
    {
        return $this->img;
    }

//    public function setContent(string $content): void
//    {
//        $this->content = $content;
//    }
//
//    public function getContent(): string
//    {
//        return $this->content;
//    }
    function cutContent(int $maxsymbol = 200)
    {
        $str = self::getContent();
        if ($maxsymbol < mb_strlen($str)) {
            $str = mb_substr($str, 0, $maxsymbol - 3) . '...';
        }
        return $str;
    }

    private function transliteration($str): string
    {
        $alphabet = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya', 'ъ' => '', 'ь' => ''
        ];
        $str = strtr($str, $alphabet);
        return $str;
    }

    public function slag($str)
    {
        $str = mb_strtolower($str);
        $str = str_replace(" ", "-", (self::transliteration($str)));
        return $str;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return int
     */
    public function getConsumption(): int
    {
        return $this->consumption;
    }

    /**
     * @param int $consumption
     */
    public function setConsumption(int $consumption): void
    {
        $this->consumption = $consumption;
    }

    /**
     * @return string
     */
    public function getMadeCar(): string
    {
        return $this->madeCar;
    }

    /**
     * @param string $madeCar
     */
    public function setMadeCar(string $madeCar): void
    {
        $this->madeCar = $madeCar;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power): void
    {
        $this->power = $power;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @param int $bodyTypeId
     */
    public function setBodyTypeId(int $bodyTypeId): void
    {
        $this->bodyTypeId = $bodyTypeId;
    }
}