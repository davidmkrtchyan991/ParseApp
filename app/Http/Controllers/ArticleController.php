<?php

namespace App\Http\Controllers;

use App\Article;
use App\Curl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $req = new Curl();
        $result = $req->sendCurl();

        return redirect('/dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show()
    {
        $articles = DB::table('articles')->paginate(10);

        return view('dashboard.show')->with('articles', $articles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if(!$article) {
            return redirect('/dashboard');
        }
        return view('dashboard.edit')->with('article', $article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // We should check here also if the posts are valid and not empty, I suppose they are valid

        $article = Article::find($id);
        if(!$article) {
            return redirect('/dashboard');
        }

        $article->title = $request->artTitle;
        $article->description = $request->artDesc;
        $file = $request->file('artImage');
        if($file != ""){
            $ext = $file->getClientOriginalExtension();
            $fileName = rand(10000, 50000) . '.' .$ext;
            $article->image = 'images/' . $fileName;
            $file->move(base_path().'/public/images', $fileName);
        }
        if( !$article->save()){
            return redirect('/');
        }

        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return json_encode('fail');
        }
        $article->delete();
        return json_encode('success');
    }
}
