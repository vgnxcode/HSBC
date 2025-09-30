<?php

namespace vgn\Http\Controllers;
use vgn\news;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    public function index() {
        $news = news::where('newsname', '<>', '')->orderBy('posted_date', 'desc')->paginate(7);
        return view('News.index')->with(['news' => $news]);
    }
}
