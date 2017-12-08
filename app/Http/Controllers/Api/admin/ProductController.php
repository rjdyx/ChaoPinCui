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
use DB;

class ProductController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
    	$datas = Product::join('categories','products.category_id','=','categories.id')
                ->whereNull('categories.deleted_at')->whereNotNull('categories.pid')
                ->leftjoin('comments',function($join){
                    $join->on('comments.product_id','=','products.id')
                    ->whereNull('comments.deleted_at');
                })
                ->orderBy('products.created_at','desc')
                ->select('products.id','products.category_id','products.name','products.desc','products.img','products.thumb',
                         'products.address','products.meridian','products.weft','products.heat','products.star_rate',
                         'categories.name as category_name', DB::raw('avg(comments.level) as comment'))
                ->groupBy('products.id','products.category_id','products.name','products.desc','products.img','products.thumb',
                          'products.address','products.meridian','products.weft','products.heat','products.star_rate', 'categories.name');
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
        $product = Product::find($id);
        $img = $product->img;
        IQuery::delImg($img);
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
            'star_rate' => 'required',
            'category_id' => 'required|exists:categories,id',
            'desc' => 'nullable',
            'address' => 'nullable|string|max:100',
            'meridian' => 'nullable|string|max:30',
            'weft' => 'nullable|string|max:30',
            'heat' => 'required'
        ]);

        if ($id == -1) {
        	$model = new Product;
        } else {
        	$model = Product::find($id);
        }

        $arr = ['name', 'desc', 'category_id', 'address', 'meridian', 'star_rate', 'weft', 'heat'];
        $model->setRawAttributes($request->only($arr));
        $model->img = IQuery::singleImg($request,'img');

        if ($model->save()) {
            IQuery::logNewOrEdit($id, 'product', 0);
            if ($id != -1) {
                $model->id = $id;
            }
            return [
                'id'=>$model->id,
                'img'=>$model->img
            ];
        }
        IQuery::logNewOrEdit($id, 'product', 1);
        return 0;
    }
}
