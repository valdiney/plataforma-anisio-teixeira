<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/email', function (Request $request) {
    return new App\Mail\SendMail($request);
});



Route::get('/teste', function (Request $request) {
    //$wordpres = new App\Helpers\WordpressService($request->limit, $request->page);
    $colaborativus = new App\Helpers\ColaborativusService();

    return $colaborativus->findCourses();
    //return $wordpres->getPosts();
});

Route::get('/form', function (Request $request) {
    if ($request->all()) {
        dd($request->all());
    }
    return view('forms.teste');
});

Route::get('/docs', function (Request $request) {
    return view('docs');
});

*/

/**/
Route::get('/teste', function (\Illuminate\Http\Request $request) {

    $collect = App\NivelEnsino::where('id', '=', 5)->with(["components" => function ($q) {
        $q->where('curricular_components.id', '!=', 31);
    }])->get();


    return response()->json($collect, 200);
});


Route::get('/{any}', 'SpaController@index')->where('any', '.*');
