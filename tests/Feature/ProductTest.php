<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // カテゴリーNoに対する商品(画像も)が取れているかを確認するテスト
    public function testGetCategory()
    {
        $response = $this->getJson('/api/categories/1/products');

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'category_name' => 'ピアス',
                ]);
    }

    // 指定した商品が確実に取得できているか確認するテスト
    public function testGetProduct()
    {
        $response = $this->getJson('/api/categories/1/products/1');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'product_name' => 'クロスシルバーピアス',
            ]);
    }


    // カテゴリーNoに対する間違った商品が紐づいていないかをテストする
    public function testFailedCategory()
    {
        $response = $this->getJson('/api/categories/2/products');

        $response->assertStatus(200)
                ->assertJsonMissing([
                    'category_name' => 'ピアス'
                ]);
    }

    // 指定した商品が確実に取得できているか確認するテスト
    public function testFailedProduct()
    {
        $response = $this->getJson('/api/categories/1/products/2');

        $response->assertStatus(200)
                ->assertJsonMissing([
                    'product_name' => 'クロスシルバーピアス'
                ]);
    }




    

    // 今回追加実装分
    // 商品登録ができることを確認する(管理者だけ)
    public function testRegisterProduct ()
    {
        $user = User::where('role', '5')->first();
        $response = $this->json('POST', '/api/categories/1/products/', [
            'title' => 'テスト商品',
            'description' => 'テストですテストですテストです',
            'price' => '1500',
            'image_url' => [''],
            'role' => $user->role
        ]);
        $response->assertStatus(200);
    }
    // 商品名や画像がなければエラーを出す
    public function testRegisterFailedProduct()
    {
        $user = User::where('role', '5')->first();
        $response = $this->json('POST', '/api/categories/1/products/', [
            'title' => '',
            'description' => 'テストテストですテストですテストですテストですテストです',
            'price' => '5500',
            'image_url' => [''],
            'role' => $user->role
        ]);
    }
    // ユーザーはできない
    public function testUserRegisterProduct()
    {
        $user = User::where('role', '10')->first();
        $response = $this->json('POST', '/api/categories/1/products/', [
            'title' => 'ユーザーとして商品追加',
            'description' => 'テストですテストですテストです',
            'price' => '5500',
            'image_url' => [''],
            'role' => $user->role
        ]);
        $response->assertStatus(200);
    }

    // 編集成功(管理者のみ)
    public function testEditProduct()
    {
        $user = User::where('role', '5')->first();
        $product = DB::table('products')->where('title','テスト商品')->first();
        $response = $this->json('PUT', `/api/categories/1/products/{$product->id}`, [
            'title' => 'テスト商品名変更',
            'description' => 'テスト商品名変更ですテスト商品名変更ですテスト商品名変更です',
            'price' => '9000',
            'image_url' => [''],
            'role' => $user->role
        ]);
        $response->assertStatus(200);
    }
    // 編集失敗(ユーザー)
    public function testEditFailedProduct()
    {
        $user = User::where('role', '10')->first();
        $product = DB::table('products')->where('title', 'テスト商品名変更')->first();
        $response = $this->json('PUT', `/api/categories/1/products/{$product->id}`, [
            'title' => 'テスト',
            'description' => 'テスト商品名変更ですテスト商品名変更ですテスト商品名変更です',
            'price' => '9000',
            'image_url' => [''],
            'role' => $user->role
        ]);
        $response->assertStatus(500);
    }
    // 編集失敗(タイトルが空)
    public function testEditTitleFailedProduct()
    {
        $user = User::where('role', '5')->first();
        $product = DB::table('products')->where('title', 'テスト商品名変更')->first();
        $response = $this->json('PUT', `/api/categories/1/products/{$product->id}`, [
            'title' => '',
            'description' => 'テスト商品名変更ですテスト商品名変更ですテスト商品名変更です',
            'price' => '9000',
            'image_url' => [''],
            'role' => $user->role
        ]);
        $response->assertStatus(500);
    }
    // 商品の削除(ユーザーは不可能)
    public function testUserDeleteProduct()
    {
        $user = User::where('role', '10')->first();
        $product = DB::table('products')->where('title', 'テスト商品名変更')->first();
        $response = $this->json('delete', `/api/categories/1/products/{$product->id}`,[
            'role' => $user
        ]);
        $response->assertStatus(200);
    }
    // 商品の削除
    public function testDeleteProduct()
    {
        $user = User::where('role', '5')->first();
        $product = DB::table('products')->where('title', 'テスト商品名変更')->first();
        $response = $this->json('delete', `/api/categories/1/products/{$product->id}`, [
            'role' => $user
        ]);
        $response->assertStatus(200);
    }

}
