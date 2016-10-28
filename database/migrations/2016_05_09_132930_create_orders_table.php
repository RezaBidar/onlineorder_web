<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * order status 
     *     basket = when products are in shopping cart
     *     request = when order request to visitor
     *     accept = when visitor accepted the order
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('visitor_id')->unsigned();
            //customer
            $table->integer('customer_id')->unsigned();
            // request to visitor
            // visitor accepted
            // visitor rejected
            // operator accepted
            // operator rejected
            $table->enum('status',['basket','request_v','accept_v','reject_v','accept_o' , 'reject_o']) ;
            $table->text('description')->nullable();
            $table->timestamps();


            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->foreign('visitor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
