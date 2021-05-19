<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Setting;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function getSliders()
    {
        return Banner::where('type' , 0)->get();
    }

    public function getHomeBanners()
    {
        return Banner::where('type' , 1)->get();
    }


    public function getSettings()
    {
        return Setting::get();
    }

    public function findSetting($key)
    {
        return Setting::where('key' , $key)->first();
    }
}
