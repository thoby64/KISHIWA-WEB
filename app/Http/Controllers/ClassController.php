<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    // Admin/Manager index (resource route)
    public function index(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $classes = ClassModel::orderBy('created_at', 'desc')->paginate(20);
        return view('auth.classes.index', compact('classes'));
    }

    // Public listing
    public function publicIndex()
    {
        $classes = ClassModel::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('classes', compact('classes'));
    }

    // Show class (used for public view and admin show)
    public function show($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('classes.show', compact('class'));
    }

    // Admin/Manager: list classes
    public function adminIndex()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $classes = ClassModel::orderBy('created_at', 'desc')->paginate(20);
        return view('auth.classes.index', compact('classes'));
    }

    public function create()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }
        return view('auth.classes.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'age_group' => 'nullable|string|max:100',
            'schedule_time' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'sometimes|boolean'
        ]);

        $class = new ClassModel($data);
        $class->created_by = Auth::id();
            // normalize boolean from request (handles arrays, 'on', '0', etc.)
            $val = $request->input('is_active');
            if (is_array($val)) { $val = end($val); }
            $class->is_active = in_array($val, [1, '1', true, 'true', 'on', 'yes'], true) ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('img/classes'), $name);
            $class->image_path = $name;
        }

        $class->save();

        return redirect()->route('auth.classes.index')->with('success', 'Class created successfully.');
    }

    public function edit(ClassModel $class)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }
        return view('auth.classes.edit', compact('class'));
    }

    public function update(Request $request, ClassModel $class)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'age_group' => 'nullable|string|max:100',
            'schedule_time' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'sometimes|boolean'
        ]);

        $class->fill($data);
        $class->updated_by = Auth::id();
            // normalize boolean from request (handles arrays, 'on', '0', etc.)
            $val = $request->input('is_active');
            if (is_array($val)) { $val = end($val); }
            $class->is_active = in_array($val, [1, '1', true, 'true', 'on', 'yes'], true) ? 1 : 0;

        if ($request->hasFile('image')) {
            // delete existing
            if ($class->image_path) {
                $old = public_path('img/classes/' . $class->image_path);
                if (file_exists($old)) {@unlink($old);}    
            }
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('img/classes'), $name);
            $class->image_path = $name;
        }

        $class->save();

        return redirect()->route('auth.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(Request $request, ClassModel $class)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        // allow AJAX JSON response
        try {
            $class->delete();
            if ($request->ajax()) {
                return response()->json(['ok' => true]);
            }
            return redirect()->route('auth.classes.index')->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
            }
            return back()->withErrors(['delete' => 'Failed to delete class: ' . $e->getMessage()]);
        }
    }
}