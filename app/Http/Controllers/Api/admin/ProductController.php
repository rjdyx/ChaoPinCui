<?php
/**
 * controller: Product
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Product;
use IQuery;

class ProductController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Product::paginate(config('app.page'));
    	return response()->json($datas);
    }

    // 查看
    public function show($id)
    {
    	return Product::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
    	$model = Product::find($id);
    	if ($model->destroy()) return $id;
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Product::find($id);
    }

    // 编辑保存
    public function update(Request $request, $id)
    {
    	return $this->storeOrUpdate($request, $id);
    }

    // 新建保存
    public function store(Request $request)
    {
    	return $this->storeOrUpdate($request);
    }

    // 新建、编辑 保存方法
    private function storeOrUpdate($request, $id = -1)
    {
    	$this->validate($request, [
            'name' => ['required','max:50',
                Rule::unique('products')->ignore($id)->where(function($query) use ($id, $pid) {
                    $query->whereNull('deleted_at');
                })
            ],
            'category_id' => 'required|exists:categories',
            'desc' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:100',
            'meridian' => 'nullable|string|max:30',
            'weft' => 'nullable|string|max:30'
        ]);

        if ($id == -1) {
        	$model = new Product;
        } else {
        	$model = Product::find($id);
        }

        $arr = ['name', 'desc', 'category_id', 'address', 'meridian', 'weft'];
        $model->setRawAttributes($request->only($arr));
        $res = IQuery::upload($request,'img');
        $model->img = $res['p'];
        $model->thumb = $res['t'];

        if ($model->save()) return 1;
        return 0;
    }
}
