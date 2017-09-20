<?php
 /*
  V1.0
  function：Collect Model
  author：guosenlin
  date：2017-09-20
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collect extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table='collects';  //绑定表
}
