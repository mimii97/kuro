<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use App\Models\ICO;
use App\Models\Blog;
use App\Models\Info;
use App\Models\Slide;
use App\Models\Social;
use App\Models\Setting;
use App\Models\VotePlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Settings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $settings = Setting::find(1);
        $slides = Slide::all();
        $infos= Info::all();
        $vote_planes= VotePlan::all();
        $socials= Social::all();
        $banners= Banner::all();
        return view('index',compact('settings','slides','infos','vote_planes','socials','banners'));
    }
    public function blog()
    {
        $settings = Setting::find(1);
        $socials= Social::all();
        $blogs = Blog::paginate(3);
        return view('blog', compact('settings','socials','blogs'));
    }
    public function ICO()
    {
        $settings = Setting::find(1);
        $socials= Social::all();
        $ICOs = ICO::all();
        return view('ICO', compact('settings','socials','ICOs'));
    }
    public function Vote()
    {
        return view('Vote-earn');
    }
   
}
