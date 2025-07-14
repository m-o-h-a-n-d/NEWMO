<?php

namespace App\Utils;

use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManger
{

    public static  function uploadImage($request, $post)
    {
        // Check if the request has files
        if ($request->hasFile('image')) {
            foreach ($request->image as $image) {
                $fileName = $post->slug . time() . rand() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('/uploads/posts', $fileName, ['disk' => 'uploads']); // Disk in fileSystem
                $post->images()->create([
                    'path' => $path, // in DataBase

                ]); // OR
                // Image::create([
                //     'post_id' => $post->id,
                //     'path' => $path, // in DataBase
                // ]);
            };
        };
    }


    // Delete image Post From Storage In Profile Post
    public static function deleteImage($post)
    {
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {


                self::deleteImageFromLocal($image->path); // Delete image from local storage
            }
        }
    }
    // Uploading Image User

    public static function UploadingUserImage($user)
    {
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = Str::slug($user->name) . rand() . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->StoreAs('uploads/users', $fileName, ['disk' => 'uploads']);
            $user->update(['image' => $path]);
        }
    }


    // UPdate Image In Setting Profile

    public static function  updateSettingImage($request, $user)
    {
        // Delete Image From local

        if ($request->file('image')) {
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image)); // Delete the old image if it exists
            }
            $image = $request->file('image');  // Get the uploaded image file
            $imageName = Str::slug($user->name) . time() . rand() . '.' . $image->getClientOriginalExtension();
            $filePath = $image->StoreAs('uploads/users', $imageName, ['disk' => 'uploads']); // Store the image in the public/uploads/users directory in the uploads disk (fileSystem)
            $user->update(['image' => $filePath]); // Update the user's image path
            $user->save();
        }
    }

    // UPdate Image In Setting Profile





    // Delete image from local storage (Edit, Delete)->posts

    public static function deleteImageFromLocal($image_path)
    {
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
    }


    public static function updateAdminImage(string $tempPath, $user)
    {
        // حذف الصورة القديمة إن وجدت
        if ($user->image && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }

        // توليد اسم جديد للصورة
        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $imageName = Str::slug($user->name) . time() . rand() . '.' . $extension;

        // مسار الصورة الجديد
        $newPath = 'uploads/users/' . $imageName;

        // نقل الصورة من temp إلى المكان النهائي
        $from = storage_path("app/{$tempPath}");
        $to = public_path($newPath);

        // إنشاء المجلد إن لم يكن موجود
        if (!File::exists(public_path('uploads/users'))) {
            File::makeDirectory(public_path('uploads/users'), 0755, true);
        }

        File::move($from, $to);

        // تحديث الصورة في قاعدة البيانات
        $user->update(['image' => $newPath]);

        return $newPath;
    }
}
