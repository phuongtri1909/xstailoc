<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Validator;

class MenusController extends Controller
{
	public function getIndex()
	{
		$menus = Menu::all()->sortBy('parent_id',SORT_DESC, false);
		return view('admin.menus.index', ['menus' => $menus]);
		//return view($this->layout);
//		return $this->setContent('admin.dashboard.dashboard');
	}

	public function getCreate()
	{
		$front = Menu::where('parent_id',0)->where('type', '=', Menu::TYPE_FRONT)
			->orderBy('sort', 'asc')->get();
		$back = Menu::where('parent_id',0)->where('type', '=', Menu::TYPE_BACK)
			->orderBy('sort', 'asc')->get();

		$back_list = [
			'Trang quản trị' => AppHelper::generateMenu($back)
		];

		$front_list = [
			'Trang chủ' => AppHelper::generateMenu($front)
		];

		$menus = array_merge($back_list,$front_list);
		return view('admin.menus.create', ['menus' => $menus]);
	}

	public function postCreate(Request $request)
	{
		$model = new Menu();
		$model->title = $request->title;
		$model->url = $request->url;
		$model->sort = $request->sort;
		$model->parent_id = $request->parent_id;
		$model->icon = $request->icon;
		$model->type = $request->type;
		$model->status = $request->status;
		$model->created_at = time();
		$this->reOrder($model);
		if ($model->save()){

			return redirect()->route('admin.menus.list');
		}
		else
			return redirect()->route('admin.menus.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate(Request $request)
	{
		$front = Menu::where('type', '=', Menu::TYPE_FRONT)
			->orderBy('sort', 'asc')->get();
		$back = Menu::where('type', '=', Menu::TYPE_BACK)
			->orderBy('sort', 'asc')->get();

		$back_list = [
			'Trang quản trị' => $this->generateMenu($back)
		];

		$front_list = [
			'Trang chủ' => $this->generateMenu($front)
		];
		$menus = array_merge($back_list,$front_list);

		$id = $request->id;
		$model = Menu::find($id);
		if (empty($model))
			return redirect()->route('admin.menus.list')->with('error', 'Thông tin không chính xác');
		return view('admin.menus.update', [
			'model' => $model,
			'menus' => $menus
		]);
	}

	public function postUpdate(Request $request)
	{
		$id = $request->id;
		$model = Menu::find($id);
		$model->title = $request->title;
		$model->url = $request->url;
		$model->sort = $request->sort;
		$model->parent_id = $request->parent_id;
		$model->icon = $request->icon;
		$model->type = $request->type;
		$model->status = $request->status;
		if ($model->save())
			return redirect()->route('admin.menus.list')->with('success', 'Cập nhật thành công');
		else
			return redirect()->route('admin.menus.update', array('id' => $id))->withErrors($model->errors)->withInput();
	}

	public function getDelete(Request $request)
	{
		$id = $request->id;
		$row = Menu::find($id);
		if ($row->delete()) {
			return redirect()->route('admin.menus.list')->with('success', 'Xóa bỏ thành công!');
		}
	}

	private function reOrder($item){
		$current_sort = Menu::where('sort',$item->sort)->where('parent_id',$item->parent_id)->where('type',$item->type)->get();
		if($current_sort->count() == 0)
			return;
		if($current_sort->count() > 1)
			echo '<meta charset="utf-8">';
			echo '<pre>'.print_r($current_sort->count(), true).'</pre>';die();
	}

	public static function generateMenu($model){
		$items = array();
		//$items[''] = '====Chọn Menu====';
		foreach($model as $item){
			$items[$item->id] = "--".$item->title;
			$chilMenu = array();
			if($item->is_parent){
				$chilMenu = self::getChilItem($item);
			}
			if(is_array($chilMenu))
				$items = $items+ $chilMenu ;
			elseif(!empty($chilMenu))
				$items[] = $chilMenu;
		}
		return $items;
	}

	private static function getChilItem($item,$subTree = 1){
		if($item->menu_child->count() > 0){
			$i = 1*$subTree;
			$tree = "--";
			for($j = 0; $j < $i; $j++){
				$tree .= "---";
			}
			foreach($item->menu_child as $childItem){
				$subChilMenu = array();
				if($childItem->is_parent){
					$i++;
					$subChilMenu = self::getChilItem($childItem,$i);
				}
				$chilMenu[$childItem->id] = $tree . $childItem->title;
				$chilMenu = $chilMenu+ $subChilMenu;
			}
			return $chilMenu;
		}
	}

}
