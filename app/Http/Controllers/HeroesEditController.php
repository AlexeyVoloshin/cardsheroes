<?php

namespace App\Http\Controllers;


use App\Models\Superhero;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HeroesEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hero = Superhero::orderby('created_at', 'desc')->paginate(6);

        return view('home', ['hero' => $hero]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('editor.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //добавить сюда валидацию с сообщениями
//        $this->validate($request , [
//            'nickname' => 'required|max:50',
//            'real_name' => 'required',
//        ]);
//
//        $hero = new Superhero();
//        $hero->nickname = $request->nickname;
//        $hero->real_name = $request->real_name;
//        $hero->original_description = $request->original_description;
//        $hero->superpower = $request->superpower;
//        $hero->catch_phrase = $request->catch_phrase;
//        if($request->file) {
//            $path = $request->file('image')->store('uploads', 'public');
//            $hero->image = substr($path, 8);
//        }else{
//            $hero->image = '';
//        }
//        $hero->save();
////        $hero->hi = 'hi';
////        $request->session()->flash('success', 'Герой создан успешно!!');
//
////        return view('editor.pages.show', [ 'hero' => $hero]);
//        return redirect()->route('editor-hero.show', ['hero' => $hero->id]);
        $rules = [
            'nickname' => 'required|max:50',
            'real_name' => 'required',
            'original_description' => 'required',
            'superpower' => 'required',
            'catch_phrase' => 'required',
        ];
        $this->validate($request, $rules);
        $hero = new Superhero();


//        $hero->nickname = $request->nickname;
//        $hero->real_name = $request->real_name;
//        $hero->original_description = $request->original_description;
//        $hero->superpower = $request->superpower;
//        $hero->catch_phrase = $request->catch_phrase;

        if($request->file('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $hero->image = substr($path, 8);
        }else{
            $hero->image = '';
        }
        $data = $request->all();
        $result = $hero
            ->fill($data)
            ->save();
//        $request->session()->flash('success', 'Данные обновлены!!');
        if($result){
            return redirect()
                ->route('editor-hero.show', ['hero' => $hero->id])
                ->with(['success' => 'Успешно сохранено!']);
        }else{
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
        //return redirect()->route('editor-hero.show', $hero->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hero = Superhero::find($id);
        if(empty($hero)){
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена!"])
                ->withInput();
        }
        return view('editor.pages.show', [ 'hero' => $hero]);
        //return view('editor.pages.show')->withHero($hero);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $hero = Superhero::find($id);
        if(empty($hero)){
            return back()
                ->withErrors(['msg' => "Запись id: {$id} не найдена!"])
                ->withInput();
        }
        return view('editor.pages.edit', [ 'hero' => $hero]);
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
        $rules = [
            'nickname' => 'required',
            'real_name' => 'required',
            'original_description' => 'required',
            'superpower' => 'required',
            'catch_phrase' => 'required',
        ];
        $this->validate($request, $rules);
        $hero = Superhero::find($id);
        if(empty($hero)){
            return back()
                ->withErrors(['msg' => "Такой id: {$id} не найден!"])
                ->withInput();
        }
        $hero = Superhero::find($id);
//        $hero->nickname = $request->nickname;
//        $hero->real_name = $request->real_name;
//        $hero->original_description = $request->original_description;
//        $hero->superpower = $request->superpower;
//        $hero->catch_phrase = $request->catch_phrase;

        if($request->file('image')) {
            $path = $request->file('image')->store('uploads' , 'public');
            $hero->image = substr($path, 8);
        }
        $data = $request->all();
        $result = $hero
            ->fill($data)
            ->save();
//        $request->session()->flash('success', 'Данные обновлены!!');
        if($result){
            return redirect()
                ->route('editor-hero.show', ['hero' => $hero->id])
                ->with(['success' => 'Успешно сохранено!']);
        }else{
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
//        return redirect()->route('editor-hero.show', ['hero' => $hero->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hero = Superhero::find($id);
        if(empty($hero)){
            return back()
                ->withErrors(['message' => "Такой id: {$id} не найден!"])
                ->withInput();
        }
        $hero->delete();
        return redirect()->route('home');
    }
}
