<?php
    /** @var array $data */
    $cars = $data['cars'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Добавление автомобиля</title>
</head>
<body>
    <div class="container">
        <div class="border border-primary p-3 mt-3">
            <form enctype="multipart/form-data" action="store" method="post">
                <div class="mb-3">
                    <p class="text-center fs-4">Добавление изображения аватара</p>
                    <div>
                        <input type='file' id="imageFile" name="image" onchange="setAvatar(this)"/>
                        <div>
                            <img id="prevImage"  style="height: 500px; width: 350px;" src="#" alt="Image" />
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <p class="text-center fs-4">Добавление изображений для слайдера</p>
                    <div class="container">
                        <div class="row">
                            <input type="file" id="fileMulti" name="fileMulti[]" onchange="readFiles(this)" multiple/>
                        </div>
                        <div class="row" id="slidesImagesPreview"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nameCar" class="form-label">Марка атомобиля</label>
                    <input type="text" class="form-control" id="nameCar" name="name">
                </div>
                <div class="mb-3">
                    <label for="capacityCar" class="form-label">Обьем двигателя</label>
                    <input type="number" class="form-control" id="capacityCar" name="capacity">
                </div>
                <div class="mb-3">
                    <label for="consumptionCar" class="form-label">Расход топлива</label>
                    <input type="number" class="form-control" id="consumptionCar" name="consumption">
                </div>
                <div class="mb-3">
                    <label for="madeCar" class="form-label">Год выпуска</label>
                    <input type="number" class="form-control" id="madeCar" name="made_car">
                </div>
                <div class="mb-3">
                    <label for="powerEngine" class="form-label">Мощность двигателя</label>
                    <input type="number" class="form-control" id="powerEngine" name="power">
                </div>
                <div class="mb-3">
                    <p>Тип кузова</p>
                    <select class="form-select" aria-label="Default select example" name="body_type_id">
                        <option selected value="1">Седан</option>
                        <option value="2">Хетчбек</option>
                        <option value="3">Универсал</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Стоимость аренды</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>
                <div class="mb-3">
                    <p>Вид КПП</p>
                    <select class="form-select" aria-label="Default select example" name="shift_box_id">
                        <option selected value="1">Механика</option>
                        <option value="2">Автомат</option>
                        <option value="3">Робот</option>
                    </select>
                </div>
                <div class="mb-3">
                    <p>Вид топлива</p>
                    <select class="form-select" aria-label="Default select example" name="fuel_type_id">
                        <option selected value="1">Бензин</option>
                        <option value="2">Дизель</option>
                        <option value="3">Газ</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Добавить автомобиль</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function readURL(file, img) {
            if (file instanceof File) {
                const reader = new FileReader();

                reader.onloadend = function(e) {
                    img.setAttribute('src', e.target.result);

                    return e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }

        function readFiles(input) {
            if (input.files && input.files[0]) {

                const divImage = document.getElementById('slidesImagesPreview');
                divImage.innerHTML = '';

                for (let key = 0; key < input.files.length; key++) {
                    const img = document.createElement('img');
                    readURL(input.files[key], img);
                    divImage.prepend(img)
                }
            }
        }

        function setAvatar(input) {
            if (input.files && input.files[0]) {
                readURL(input.files[0], document.getElementById('prevImage'));
            }
        }
    </script>
</body>
</html>