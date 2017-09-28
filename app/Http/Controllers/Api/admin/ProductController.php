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
    	$datas = Product::join('categories','products.category_id','=','categories.id')
                ->orderBy('products.created_at','desc')
                ->select('products.*','categories.name as category_name');
        $datas = IQuery::ofText($datas, $request->query_text, 'product' , ['products.name']);
        $datas = $datas->paginate(config('app.page'));
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
        if (Product::destroy($id)) {
            IQuery::ofLog('product', 4, 0);
            return $id;
        }
        IQuery::ofLog('product', 4, 1);
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
            'name' => 'required','max:50',
            'category_id' => 'required|exists:categories,id',
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
        $res = IQuery::upload($request,'img', true);
        $model->img = $res['p'];
        $model->thumb = $res['t'];

        if ($model->save()) {
            IQuery::logNewOrEdit($id, 'product', 0);
            return 1;
        }
        IQuery::logNewOrEdit($id, 'product', 1);
        return 0;
    }
}
