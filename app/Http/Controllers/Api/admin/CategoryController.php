<?php
/**
 * controller: Category
 * autoer: guosenlin
 * date: 2017/09/14
*/
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Model\Category;
use IQuery;
use DB;

class CategoryController extends Controller
{
	// 分页信息
    public function index(Request $request)
    {
        $datas = Category::whereNull('pid')->orderBy('created_at','asc');    
        $datas = IQuery::ofText($datas, $request->query_text, 'category', ['categories.name']);
        $datas = $datas->paginate(config('app.page'));
        $datas = $this->childIsExist($datas);

    	return response()->json($datas);
    }

    public function childIsExist($datas)
    {
        $lists = $datas;
        foreach ($lists as $k => $list) {
            $count = Category::where('pid', $list->id)->count();
            if ($count) {
                $datas[$k]->dels = $count;
            } else {
                $datas[$k]->dels = null;
            }
        }
        return $datas;
    }

    // 查看
    public function show($id)
    {
    	return Category::find($id);
    }

    // 单条删除
    public function destroy($id)
    {
        $childs = Category::where('pid',$id)->get();
        if (count($childs)) return -1;
        $category = Category::find($id);
        $img = $category->img;
        $ico = $category->ico;
        IQuery::delImg($img);
        IQuery::delImg($ico);
    	if (Category::destroy($id)) {
            IQuery::ofLog('category', 4, 0);
            return $id;
        }
        IQuery::ofLog('category', 4, 1);
    	return 0;
    }

    // 编辑
    public function edit($id)
    {
    	return Category::find($id);
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
    private function storeOrUpdate($request, $id=-1)
    {
        $pid = $request->pid;
    	$this->validate($request, [
            'name' => ['required','max:30',
                Rule::unique('categories')->ignore($id)->where(function($query) use ($id, $pid) {
                    $query->whereNull('deleted_at');
                })
            ],
            'desc' => 'nullable|max:255'
        ]);

        if ($id == -1) {
        	$model = new Category;
        } else {
        	$model = Category::find($id);
        }

        $arr = ['name','desc'];
        $model->setRawAttributes($request->only($arr));

        $model->ico = IQuery::singleImg($request,'ico');
        $model->img = IQuery::singleImg($request,'img');

        if ($model->save()) {
            if ($id != -1) {
                $model->id = $id;
            }
            IQuery::logNewOrEdit($id, 'category', 0);
            return [
                'id'=>$model->id,
                'img'=>$model->img,
                'ico'=>$model->ico
            ];
        }
        IQuery::logNewOrEdit($id, 'category', 1);
        return 0;
    }

    public function all(Request $request) {
        // $datas = Category::join('categories as parent','categories.pid','=','parent.id')->whereNull('parent.pid')
        //       ->whereNotNull('categories.pid')->whereNull('parent.deleted_at')
        //       ->select('parent.id','parent.name', 'categories.id as category_id', 'categories.name as category_name')->get();
        $datas = Category::whereNull('deleted_at')->select('id', 'name', 'pid')->get();
        return $datas;
    }
}
