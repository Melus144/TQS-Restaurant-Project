<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Recipes
 *
 * Endpoints for recipes management
 */
class RecipeController extends Controller
{
    /**
     * Get all recipes
     *
     * Retrieve all recipes from database.
     *
     * Returns 200 OK if database contains any recipe.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "recipes", "id": 1, "attributes": {
     * "name": "Estofado de ternera", "price": 15, "type": "recipe_type", "food_type": "food_type",
     * "available": true, "food": {
     * "type": "food", "id": 1, "attributes": {
     * "name": "ternera", "units": "kg", "quantity": 15, "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}},
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}},
     * {"type": "recipes", "id": 1, "attributes": {
     * "name": "Estofado de ternera", "price": 15, "type": "recipe_type", "food_type": "food_type",
     * "available": true, "food": {
     * "type": "food", "id": 1, "attributes": {
     * "name": "ternera", "units": "kg", "quantity": 15, "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}},
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}}]
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $recipes = Recipe::all();

        return RecipeCollection::make($recipes)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create a recipe
     *
     * Endpoint for creating a recipe.
     *
     * Returns 201 CREATED when created.
     *
     * @param RecipeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());

        if ($request->hasFile('image')) {
            $fileName = $recipe->id . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('images/recipes', $fileName, 'public');

            $recipe->update(['image' => $path]);
        }

        if ($request->has('food')) {
            foreach ($request->get('food') as $food) {
                $recipe->food()->attach($food['food_id'], ['quantity' => $food['quantity']]);
            }
        }

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Get a single recipe
     *
     * User retrieves a single recipe from database.
     *
     * Returns 200 OK if recipe exists.
     *
     * @param Recipe $recipe
     * @return \Illuminate\Http\JsonResponse
     * @response 200 {"type": "recipes", "id": 1, "attributes": {
     * "name": "Estofado de ternera", "price": 15, "type": "recipe_type", "food_type": "food_type",
     * "available": true, "food": {
     * "type": "food", "id": 1, "attributes": {
     * "name": "ternera", "units": "kg", "quantity": 15, "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}},
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}}
     */
    public function show(Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        return RecipeResource::make($recipe)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update a recipe
     *
     * Endpoint for creating a recipe.
     *
     * Returns 204 NO_CONTENT when updated.
     *
     * @param RecipeRequest $request
     * @param Recipe $recipe
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RecipeRequest $request, Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        $recipe->update($request->safe()->only(['name', 'price', 'type', 'food_type', 'available']));

        if ($request->hasFile('image')) {
            if ($recipe->image != null) {
                Storage::disk('public')->delete($recipe->image);
            }

            $fileName = $recipe->id . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('images/recipes', $fileName, 'public');

            $recipe->update(['image' => $path]);
        }

        if ($request->has('food')) {
            $recipe->food()->detach();
            foreach ($request->get('food') as $food) {
                $recipe->food()->attach($food['food_id'], ['quantity' => $food['quantity']]);
            }
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a recipe
     *
     * Endpoint for deleting a recipe.
     *
     * Returns 204 NO_CONTENT when deleted.
     *
     * Returns 409 CONFLICT if the recipe exists in 1 or more orders.
     *
     * @param Recipe $recipe
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        if (count($recipe->orders) > 0) {
            return response()->json([
                'message' => 'No se puede eliminar la receta debido a es usada en algunas comandas.'
            ], Response::HTTP_CONFLICT);
        }

        if ($recipe->image != null) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->food()->detach();
        $recipe->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
