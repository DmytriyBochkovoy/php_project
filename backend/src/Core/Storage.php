<?php

namespace It20Academy\App\Core;

use It20Academy\App\Service\QueryBuilder;

class Storage
{
    public array $file = [];

    public function filesHandler ($files, $id, $nameInputAvatar, $nameInputSlider) {

        $date = date("Y-m-d H:i:s");
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/storage/';

        if (move_uploaded_file($files["{$nameInputAvatar}"]['tmp_name'], $uploadfile = $uploaddir . $date)) {
            $this->file = [
                'name' => $files["{$nameInputAvatar}"]['name'],
                'car_id' => $id,
                'url' => '/storage/' . $date,
                'category' => 'avatar',
                'type' => $files["{$nameInputAvatar}"]['type'],
                'size' => $files["{$nameInputAvatar}"]['size'],
            ];
            $this->insertFile($this->file);
        }

        for ($i = 0; $i < count($files["{$nameInputSlider}"]['name']);  $i++) {
            $uploadfile = $uploaddir . $date . "-{$i}";

            if (move_uploaded_file($files["{$nameInputSlider}"]['tmp_name'][$i], $uploadfile)) {
                $this->file = [
                    'name' => $files["{$nameInputSlider}"]['name'][$i],
                    'car_id' => $id,
                    'url' => '/storage/' . $date . "-{$i}",
                    'category' => 'slider',
                    'type' => $files["{$nameInputSlider}"]['type'][$i],
                    'size' => $files["{$nameInputSlider}"]['size'][$i]
                ];
                $this->insertFile($this->file);
            }
        }
    }

    public function insertFile (array $file): void
    {

        $dbh = (new Db())->getHandler();
        $queryBuilder = new QueryBuilder();

        $queryBuilder->insert()->into('files', $file);
        $stmt = $dbh->prepare($queryBuilder->getQuery());

        $stmt->execute();
    }
}