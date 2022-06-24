<?php
/** @var array $data */
    $cars = $data['cars'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Главная</title>
</head>
<body>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php
            foreach ($cars as $car):
        ?>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div style="max-width: 500px">
                            <img src="<?php echo $car->avatar()->url;?>" class="w-100" alt="...">
                        </div>
                        <p class="card-text">
                            <?php
                                echo $car->name;
                            ?>
                        </p>
                        <p class="card-text">
                            <span>Обьем двигателя: </span>
                            <?php
                                echo $car->capacity;
                            ?>
                            <span>л</span>
                        </p>
                        <p class="card-text">
                            <span>Расход топлива: </span>
                            <?php
                                echo $car->consumption;
                            ?>
                            <span>на 100км</span>
                        </p>
                        <p class="card-text">
                            <span>Год выпуска: </span>
                            <?php
                                echo $car->made_car;
                            ?>
                        </p>
                        <p class="card-text">
                            <span>Стоимость аренды: </span>
                            <?php
                                echo $car->price;
                            ?>
                            <span>$</span>
                        </p>
                        <p class="card-text">
                            <span>Тип кузова: </span>
                            <?php
                                echo $car->bodyType()->name ?? '';
                            ?>
                        </p>
                        <p class="card-text">
                            <span>КПП: </span>
                            <?php
                                echo $car->shiftBox()->name ?? '';
                            ?>
                        </p>
                        <p class="card-text">
                            <span>Тип топлива: </span>
                            <?php
                                echo $car->fuilType() ?? '';
                            ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="cars/show/<?php echo $car->id; ?>"
                                   class="btn btn-primary my-2">
                                    Смотреть авто
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-8 col-md-8 mx-auto">
                <p>
                    <a href="cars/create" class="btn btn-primary my-2">Добавить автомобиль</a>
                </p>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous">
    </script>
</body>
</html>