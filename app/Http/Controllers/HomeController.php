<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /** вывести страницу для одного, выбранного ранее города */
    public function main()
    {
        /** @var $raw_city string текущий город из сессии */
        $raw_city = Session::get('current_city');
        /** @var $url string город из prefix */
        $url = request()->segment(1);
        /** если поменяли город в адресной строке, то установим его и в сессии */
        if($raw_city !== $url && in_array($url, Config::get('app.cities'))){
            Session::flush();
            Session::put('current_city', $url);
        }
        return view('main');
    }
}
