<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

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
        return view('home');
    }


    public function diplay_image($filename)
    {
       $img = str_replace('-', '.', $filename);
        //echo $filename;
        //return Image::make(public_path('images/'. $filename.'.png'))->response();
      // return Image::make('images/'. $filename.'.png')->response();
        return Image::make(storage_path() . '/app/company/'. $img)->response();
        // $path = storage_public('images/' . $filename);

        // if (!File::exists($path)) {

        //     abort(404);

        // }

        // $file = File::get($path);

        // $type = File::mimeType($path);

      

        // $response = Response::make($file, 200);

        // $response->header("Content-Type", $type);

      

        // return $response;
    }
}
