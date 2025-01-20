<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $relationship = User::query()->getModel()->post();

    $existenceQuery = $relationship->getRelationExistenceQuery(
        $relationship->getRelated()->query(),
        User::query(),
        ['id'],
    );

    $query = User::orderBy($existenceQuery, 'desc');

    // $query->ddRawSql();

    // User Beta should be first
    // User Alpha should be second
    // @see database/seeders/DatabaseSeeder.php
    return $query->get();
});
