<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // الحماية تتم عبر middleware auth:admin على مستوى المسار
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'العنوان مطلوب.',
            'category_id.required' => 'الرجاء اختيار القسم.',
            'category_id.exists' => 'القسم المختار غير صالح.',
            'content.required' => 'محتوى المنشور مطلوب.',
            'cover_image.image' => 'يجب أن تكون صورة الغلاف ملف صورة.',
            'cover_image.mimes' => 'صيغ الصور المسموحة: jpg، jpeg، png، webp.',
            'cover_image.max' => 'حجم الصورة يجب ألا يتجاوز 4 ميغابايت.',
        ];
    }
}
