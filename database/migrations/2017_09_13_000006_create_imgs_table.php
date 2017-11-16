<?php
/**
 * table: imgs
 * author: guosenlin
 * date: 2017/09/13
*/
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('特色id');
            $table->string('name', 50)->comment('名称');
            $table->string('desc', 255)->nullable()->comment('描述');
            $table->integer('sort')->default(100)->comment('排序');
            $table->string('img', 50)->comment('原图');
            $table->softDeletes();
            $table->timestamps();
        });
        
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imgs');
    }
}
