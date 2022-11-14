<?php

namespace App\Admin\Food\Controllers;

use App\Admin\Food\Requests\FoodRequest;
use App\Models\Food;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class FoodController
{
    public function index(): View
    {
        return view('admin.food.index');
    }

    public function edit(Food $food): View
    {
        return view('admin.food.edit', compact('food'));
    }

    public function create(): View
    {
        $food = new Food();
        return view('admin.food.create', compact('food'));
    }

    public function store(FoodRequest $request): RedirectResponse
    {
        //$food = Food::Factory()->create($request->validated());
        $food = Food::Factory()->create([
            'name' => $request->name,
            'units' => $request->units,
            'type' => $request->type
        ]);
        /*$user = User::Factory()->create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "phone" => $request->phone
        ]);*/
        return redirect()
            ->route('admin.food.edit', $food)
            ->with('status', 'The food has been created successfully.');
    }

    public function update(FoodRequest $request, Food $food): RedirectResponse
    {
        $food->fill([
            'name' => $request->name,
            'units' => $request->units,
            'type' => $request->type,
        ]);

        $food->save();

        $food->refresh();

        return redirect()
            ->route('admin.food.edit', $food)
            ->with('status', 'The food has been updated.');
    }

    public function destroy(Food $food)
    {
        Food::where('id', $food->id)->delete();
        return redirect()
            ->route('admin.food.index');
    }
}
