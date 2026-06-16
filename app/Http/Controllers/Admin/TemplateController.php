<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(10);
        $totalTemplates = Template::count();
        $totalUsers = \App\Models\User::count();

        return view('admin.templates', compact('templates', 'totalTemplates', 'totalUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'view_path'      => 'required|string|max:255',
            'thumbnail'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'default_styles' => 'nullable|string',
            'is_active'      => 'nullable|boolean',
        ]);

        $data = [
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'view_path'      => $request->view_path,
            'default_styles' => $request->default_styles
                                    ? json_decode($request->default_styles, true)
                                    : null,
            'is_active'      => $request->boolean('is_active'),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Template::create($data);

        return redirect()->route('admin.templates.index')
                         ->with('success', 'Tạo template thành công!');
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'view_path'      => 'required|string|max:255',
            'thumbnail'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'default_styles' => 'nullable|string',
            'is_active'      => 'nullable|boolean',
        ]);

        $data = [
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'view_path'      => $request->view_path,
            'default_styles' => $request->default_styles
                                    ? json_decode($request->default_styles, true)
                                    : null,
            'is_active'      => $request->boolean('is_active'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($template->thumbnail) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $template->update($data);

        return redirect()->route('admin.templates.index')
                         ->with('success', 'Cập nhật template thành công!');
    }

    public function destroy(Template $template)
    {
        if ($template->thumbnail) {
            Storage::disk('public')->delete($template->thumbnail);
        }

        $template->delete();

        return redirect()->route('admin.templates.index')
                         ->with('success', 'Xoá template thành công!');
    }

    public function toggleActive(Template $template)
    {
        $template->update(['is_active' => !$template->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $template->is_active,
        ]);
    }
}
