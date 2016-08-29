<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(FinxiImoveis\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(FinxiImoveis\Entities\ImovelStatus::class, function (Faker\Generator $faker) {

    return [
        'label'     => $faker->word,
        'descricao' => $faker->sentence,
        'ativo'     => $faker->boolean
    ];
});

$factory->define(FinxiImoveis\Entities\Imovel::class, function (Faker\Generator $faker) {

    return [
        'user_id'           => function () {
            return factory(FinxiImoveis\User::class)->create()->id;
        },
        'imoveis_status_id' => function () {
            return factory(FinxiImoveis\Entities\ImovelStatus::class)->create()->id;
        },
        'descricao'         => $faker->sentence,
        'contato_nome'      => $faker->name,
        'contato_email'     => $faker->email,
        'contato_telefone'  => $faker->numerify('+#############'),
        'imagem'            => $faker->url.'/'.$faker->word.'.jpg',
        'cep'               => $faker->numerify('########'),
        'logradouro'        => $faker->streetName,
        'numero'            => $faker->buildingNumber,
        'complemento'       => $faker->sentence,
        'bairro'            => $faker->word,
        'localidade'        => $faker->city,
        'uf'                => $faker->stateAbbr,
        'latitude'          => $faker->latitude,
        'longitude'         => $faker->longitude,
        'preco_locacao'     => $faker->randomNumber(3),
        'preco_iptu'        => $faker->randomNumber(3),
        'preco_condominio'  => $faker->randomNumber(3),
    ];
});