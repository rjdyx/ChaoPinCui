<?php
 /*
  V1.0
  function：Feedback Model
  author：guosenlin
  date：2017-09-19
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table='feedbacks';  //绑定表
}
