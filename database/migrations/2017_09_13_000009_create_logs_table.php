<?php
/**
 * table: logs
 * author: guosenlin
 * date: 2017/09/18
*/
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('img', 50)->comment('模块名称');
            $table->string('operate', 50)->comment('操作行为');
            $table->string('ip', 50)->comment('ip地址');
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
        Schema::dropIfExists('logs');
    }
}
