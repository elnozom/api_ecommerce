<?php

namespace App\Http\Controllers\admin;

use App\Banner;
use App\Group;
use App\Http\Controllers\Controller;
use App\QueryFilters\BannerType;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class GlobalController extends Controller
{
    public function delete($table , $id)
    {
        $record = DB::table($table)->where('id' , $id);
        if(count($record->get()) == 0){
            return response()->json('Sorry !this record can\'t be found');
        }
        $record->delete();
        return response()->json('Deleted Sucessfully');

    }
    public function banners()
    {
        $pipeline = app(Pipeline::class)->send(Banner::query())->through([
            BannerType::class

        ])->thenReturn();
        $banners = $pipeline->paginate(8);
        
        return $banners;
    }

    public function createBanner(Request $request , $type)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'images' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // dd($files=$request->file('images'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
                      
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $filename);
            $request->image =$filename;
        }  
        $banner = Banner::create(['image' => $request->image , 'type' => $type]);
        return $banner;
    }

    public function editBanner(Request $request , $id)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'images' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $banner = Banner::find($id);
        if($banner == null){
            return response()->json('this banner not found' , 400);
        }
        // dd($files=$request->file('images'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = $name . time() . '.' . $extension;
                      
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $filename);
            $banner->image =$filename;
            $banner->save();
        }  
        return $banner;
    }
    public function groups(){
        $group = Group::select([
            "id","GroupNameEn","GroupName"
        ])->get();
        return $group;
    }
}
