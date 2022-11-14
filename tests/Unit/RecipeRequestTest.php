<?php

use App\Admin\Food\Requests\RecipeRequest;
use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RecipeRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        Food::factory()->count(3)->create();

        $request = new RecipeRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        Food::factory()->count(3)->create();

        $request = new RecipeRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {
        return [
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 2,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 3,
                'available' => true,
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 4,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg')
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 5,
                'available' => true
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 0,
                'image' => UploadedFile::fake()->image('photo1.jpg')
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => str_repeat('A', 1),
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => str_repeat('A', 2),
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => str_repeat('A', Recipe::NAME_MAX_LENGTH - 1),
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => str_repeat('A', Recipe::NAME_MAX_LENGTH),
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]]
        ];
    }

    public function invalid_data_provider(): array
    {
        return [
            [[
                'name' => 'foo'
            ]],
            [[
                'price' => 19.99
            ]],
            [[
                'type' => Recipe::TYPE_FIRST_COURSE
            ]],
            [[
                'name' => '',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => null,
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => null,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 'not a double',
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => null,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => 'not an integer',
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => null,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => '',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 'not an integer',
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => 'not a boolean',
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 450.50],
                    ['food_id' => 2, 'quantity' => 350.50],
                    ['food_id' => 3, 'quantity' => 250.50],
                ]
            ]],
            // TODO - Uncomment when images are fixed
//            [[
//                'name' => 'foo',
//                'price' => 19.99,
//                'type' => Recipe::TYPE_FIRST_COURSE,
//                'available' => true,
//                'image' => 'not an image',
//                'food' => [
//                    ['food_id' => 1, 'quantity' => 450.50],
//                    ['food_id' => 2, 'quantity' => 350.50],
//                    ['food_id' => 3, 'quantity' => 250.50],
//                ]
//            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => 'not an array'
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => -1, 'quantity' => 450.50],
                    ['food_id' => 0, 'quantity' => 350.50],
                    ['food_id' => 4, 'quantity' => 250.50],
                    ['food_id' => 5, 'quantity' => 750.50],
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => null]
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1, 'quantity' => 'not a numeric']
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => null, 'quantity' => 450.50]
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 'not an integer', 'quantity' => 450.50]
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['quantity' => 450.50]
                ]
            ]],
            [[
                'name' => 'foo',
                'price' => 19.99,
                'type' => Recipe::TYPE_FIRST_COURSE,
                'food_type' => 1,
                'available' => true,
                'image' => UploadedFile::fake()->image('photo1.jpg'),
                'food' => [
                    ['food_id' => 1]
                ]
            ]]
        ];
    }
}
