<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Symfony\Component\HttpFoundation\Response;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $genre = Genre::all();
            return Datatables::of($genre)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="genredelete(\'' . $data->id . '\')"><i class="icon-trash"></i>Delete</a>&nbsp;&nbsp;
                    <a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('genre.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i>Edit</a>
                    
                    '
                    ;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view ('admin.genre.index');
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
    public function store(Request $request)
    {
        if($request->ajax()){
            $genre = new Genre();
            $genre->Genre = $request->genre;
            if ($genre->save()) {
                return response([
                    'success'=>True,
                    'message'=>'Genre  created Succesfully',
                ],Response::HTTP_OK);
            }else{
                return response([
                    'error'=>True,
                    'message'=>'Genre not created',
                ],Response::HTTP_OK);
            }
        }
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $genres =Genre::where('id',$id)->get();
                 

        return view ('admin.genre.edit',compact('genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        Genre::where('id',$id)
                    ->update([
                        'genre'=> $request->genre
                    ]);

                    return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->ajax()){
                $genre_id = $request->genre_id;
        $genre = Genre::find($genre_id);
        if ($genre) {
            $genre->delete();
            return response([
                'success'=>True,
                'message'=>'Genre  deleted Succesfully',
            ],Response::HTTP_OK);
        } else {
            return response([
                'success'=>True,
                'message'=>'Genre  not deleted',
            ],Response::HTTP_OK);
        }
        }
    
    }

}