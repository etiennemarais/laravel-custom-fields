<?php

$factory->define(\Metafields\Models\Metafield::class, function (Faker\Generator $faker) {
    return [
        'title' => 'Custom Name',
        'model' => 'example',
        'type' => \Metafields\Types\Text::$type,
        'options' => null,
    ];
});
