<?php

namespace App\Http\Controllers;

use App\Exports\TrainersExport;
use App\Models\Trainer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainer::active()->orderBy('id');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'ilike', "%{$term}%")
                  ->orWhere('apellido', 'ilike', "%{$term}%");
            });
        }

        $trainers = $query->get();
        $trashedCount = Trainer::onlyTrashed()->count();

        return view('trainers.index', compact('trainers', 'trashedCount'));
    }

    public function trashed()
    {
        $trainers = Trainer::onlyTrashed()->get();
        return view('trainers.trashed', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $trainer = new Trainer();
        $trainer->name = $data['name'];
        $trainer->apellido = $data['apellido'];

        if ($request->hasFile('avatar')) {
            $trainer->avatar = $this->saveAvatar($request->file('avatar'));
        }

        $trainer->save();

        return redirect()->route('trainers.index')
            ->with('success', 'Trainer creado exitosamente');
    }

    public function show(Trainer $trainer)
    {
        return view('trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $trainer->name = $data['name'];
        $trainer->apellido = $data['apellido'];

        if ($request->hasFile('avatar')) {
            $this->deleteAvatar($trainer->avatar);
            $trainer->avatar = $this->saveAvatar($request->file('avatar'));
        }

        $trainer->save();

        return redirect()->route('trainers.show', $trainer)
            ->with('success', 'Trainer actualizado exitosamente');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()->route('trainers.index')
            ->with('success', 'Trainer movido a la papelera');
    }

    public function forceDestroy($id)
    {
        $trainer = Trainer::withTrashed()->findOrFail($id);

        $this->deleteAvatar($trainer->avatar);
        $trainer->forceDelete();

        return redirect()->route('trainers.index')
            ->with('success', 'Trainer y su imagen eliminados permanentemente');
    }

    public function emptyTrash()
    {
        foreach (Trainer::onlyTrashed()->get() as $trainer) {
            $trainer->forceDeleteTrainer();
        }

        return redirect()->route('trainers.index')
            ->with('success', 'Papelera vaciada');
    }

    // PDF: ficha individual (con $id) o listado completo (sin $id)
    public function downloadPdf(?int $id = null)
    {
        if ($id) {
            $trainer = Trainer::findOrFail($id);

            return Pdf::loadView('trainers.pdf', compact('trainer'))
                ->download('ficha-' . Str::slug($trainer->name . ' ' . $trainer->apellido) . '.pdf');
        }

        $trainers = Trainer::active()->orderBy('id')->get();

        return Pdf::loadView('trainers.pdf', compact('trainers'))
            ->setPaper('a4', 'landscape')
            ->download('listado-trainers.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new TrainersExport, 'listado-trainers.xlsx');
    }

    private function saveAvatar($file): string
    {
        $dir = public_path('images');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = time() . '_' . Str::random(6) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move($dir, $filename);

        return $filename;
    }

    private function deleteAvatar(?string $filename): void
    {
        if ($filename) {
            $path = public_path('images/' . $filename);
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }
}