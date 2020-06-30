<?php

namespace App\Http\Controllers;

use App\Company;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public $auth_user = "";
    public function __construct()
    {
        $user = Auth::user();
        $this->auth_user = Auth::id();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        $title = "Menu List";
        return view('pages.menus.list', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Menu";
        return view('pages.menus.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'route' => 'required',
        ]);
        try {
            $user_id = Auth::user()->id;
            $menu = new Menu();
            $menu->user_id = $user_id;
            $menu->name = $request->name;
            $menu->url = $request->route;
            $menu->save();

            return redirect()->route('menu.index')->with('status', 'Menu created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('menu.index')->with('status', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $title = "Menu";
        return redirect()->route('menu.show', compact('title', 'menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $title = "Edit menu";
        return view('pages.menus.edit', compact('title', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'name' => 'required',
            'route' => 'required',
        ]);
        try {
            $menu->update([
                'name' => $request->name,
                'url' => $request->route
            ]);
            return redirect()->route('menu.index')->with('status', 'Menu has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('menu.index')->with('status', 'Something went wrong in update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('status', 'Menu has been deleted successfully.');
    }
}
