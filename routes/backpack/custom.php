<?php

use App\Models\News;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    
    Route::get('/', function () {
        $news = News::all();
        return view('home' , compact('news'));
    })->name('home');
    
    Route::crud('user', 'UserCrudController');
    Route::crud('branch', 'BranchCrudController');
    
    Route::get('storage/{filename}', function ($filename){
       
        $path = storage_path('app/public/images/avatars/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('user.avatar');


    Route::group([
        'middleware' => "can:writeNews",
    ] , function(){
        Route::crud('category', 'CategoryCrudController');
    });
    Route::crud('news', 'NewsCrudController');
    
}); // this should be the absolute last line of this file