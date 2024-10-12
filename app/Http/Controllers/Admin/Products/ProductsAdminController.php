<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\JoinChatRequest;
use App\Http\Requests\ProductAdminRequest;
use App\Models\Chat;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsAdminController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $chats = \App\Models\Chat::all();
        return view('admin.products.product-create', compact('chats'));
    }

    public function store(ProductAdminRequest $productAdminRequest): \Illuminate\Http\RedirectResponse
    {
        try {
            $product = Product::create($productAdminRequest->validated());

            // Проверка, был ли загружен файл видео
            if ($productAdminRequest->hasFile('video')) {
                $video = $productAdminRequest->file('video');
                // Сохраняем файл в директорию videos
                $data['video'] = $video->store('files/videos', 'public');
                $product->update(['video' => $data['video']]);
            }

            // Если файл картинки был загружен
            if ($productAdminRequest->hasFile('picture')) {
                $pictureFile = $productAdminRequest->file('picture');
                $filePath = $pictureFile->store('files/pictures', 'public'); // Сохраняем картинку в папке 'public/pictures'

                // Создаем запись в pictures через связь
                $product->pictures()->create([
                    'orig' => $filePath,
                ]);
            }

            return redirect(route('products_admin'))
                ->with('success', 'Продукт успешно создан');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при добавлении: ' . $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        $chats = \App\Models\Chat::all();

        return view('admin.products.product-edit', compact('product', 'chats'));
    }

    public function update(Product $product, ProductAdminRequest $productAdminRequest): \Illuminate\Http\RedirectResponse
    {
        try {
            $product->update($productAdminRequest->validated());

            // Проверяем, был ли загружен новый файл изображения
            if ($productAdminRequest->hasFile('picture')) {
                // Получаем новый загруженный файл
                $pictureFile = $productAdminRequest->file('picture');
                $filePath = $pictureFile->store('files/pictures', 'public'); // Сохраняем картинку в папке 'public/pictures'

                // Удаляем старую картинку, если она существует
                if ($product->pictures()->exists()) {
                    $oldPicture = $product->pictures()->first(); // Получаем первое изображение
                    Storage::disk('public')->delete($oldPicture->orig); // Удаляем старый файл
                    $oldPicture->delete();
                }

                // Создаем новую запись в pictures через связь
                $product->pictures()->create([
                    'orig' => $filePath,
                ]);
            }

            // Проверяем, было ли загружено новое видео
            if ($productAdminRequest->hasFile('video')) {
                // Получаем новый загруженный файл видео
                $videoFile = $productAdminRequest->file('video');
                $videoPath = $videoFile->store('files/videos', 'public'); // Сохраняем видео в папке 'public/videos'

                // Удаляем старое видео, если оно существует
                if ($product->video) {
                    Storage::disk('public')->delete($product->video); // Удаляем старое видео с диска
                }

                // Обновляем ссылку на новое видео в продукте
                $product->update(['video' => $videoPath]);
            }

            return redirect(route('products_admin'))
                ->with('success', 'Продукт успешно обновлен');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при обновлении: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect(route('products_admin'))
                ->with('success', 'Продукт успешно удален');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при удалении: ' . $e->getMessage()]);
        }
    }
}
