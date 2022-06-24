<?php
/** @var array $data */
    $car = $data['car'];
    $fuelType = $data['fuelType'];
    $shiftBox = $data['shiftBox'];
    $bodyType = $data['bodyType'];
    $imagesCar = $data['files'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Просмотр автомобиля</title>
</head>
<body>
    <div class="container-xxl">
        <div class="row my-4">
            <div class="col-12 my-3 d-flex justify-content-center">
                <div class="fs-3 text-primary">
                    <?php
                        echo $car->name;
                    ?>
                </div>
            </div>
            <div class="col-5">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselInner">
                        <?php
                            foreach ($imagesCar as $imagCar):
                        ?>
                            <div class="carousel-item">
                                <img src="<?php echo $imagCar['url'];?>" class="w-100" alt="...">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev"
                    >
                  <span
                      class="carousel-control-prev-icon"
                      aria-hidden="true"
                  ></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carouselExampleControls"
                            data-bs-slide="next"
                    >
                  <span
                          class="carousel-control-next-icon"
                          aria-hidden="true"
                  ></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col-12 my-2">
                        <span class="fs-4">Характеристики</span>
                    </div>
                    <div class="col-6 fs-5">
                        <div>Тип кузова - <?php echo $bodyType->name?></div>
                        <div>Объем двигателя - <?php echo $car->capacity?></div>
                        <div>Тип трансмиссии - <?php echo $shiftBox->name?></div>
                    </div>
                    <div class="col-6 fs-5">
                        <div>Тип топлива - <?php echo $fuelType->name?></div>
                        <div>Рассход - <?php echo $car->consumption?> л.</div>
                        <div>Год выпуска - <?php echo $car->made_car?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous">
    </script>
    <script>
        let div = document.getElementById('carouselInner');
        div.firstElementChild.classList.add('active');
    </script>
</body>
</html>