<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImoveisTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imoveis', function(Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('imoveis_status_id')->unsigned();

            $table->text('descricao');

            $table->string('contato_nome');
            $table->string('contato_email');
            $table->string('contato_telefone',20);

            $table->string('imagem');

            $table->string('cep',8);
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('localidade');
            $table->string('uf',2);

            $table->double('preco_locacao');
            $table->double('preco_condominio');
            $table->double('preco_iptu');



            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('imoveis_status_id')
                ->references('id')->on('imoveis_status')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imoveis');
	}

}
