<?php

use Illuminate\Database\Seeder;

class ImoveisStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('imoveis_status')->insert([
            [
                'id'        => 1,
                'label'     => 'Em Criação',
                'descricao' => 'O imóvel foi criado, mas não está disponível para alugar',
                'ativo'     => false
            ]
        ]);

        DB::table('imoveis_status')->insert([
            [
                'id'        => 2,
                'label'     => 'Disponível',
                'descricao' => 'O imóvel está disponível para alugar',
                'ativo'     => true
            ]
        ]);

        DB::table('imoveis_status')->insert([
            [
                'id'        => 3,
                'label'     => 'Alugado',
                'descricao' => 'O imóvel já foi alugado, não está disponível para alugar',
                'ativo'     => false
            ]
        ]);

        DB::table('imoveis_status')->insert([
            [
                'id'        => 4,
                'label'     => 'Cancelado',
                'descricao' => 'O cadastro do imóvel está cancelado',
                'ativo'     => false
            ]
        ]);
    }
}