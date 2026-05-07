<?php


namespace App\Services;

use App\Models\Violation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ViolationService
{
    /**
     * Create new violation (Staff/Admin only)
     */
    public function create(array $data): Violation
    {
        $data['reported_by'] = Auth::id();

        return Violation::create($data);
    }

    /**
     * Get all violations (paginated, with relations) - Staff/Admin
     */
    public function getAll(int $perPage = 15, ?string $search = null, ?string $cohort = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Violation::with(['student', 'reporter'])
            ->when($cohort, function ($query) use ($cohort) {
                $query->whereHas('student', function ($query) use ($cohort) {
                    $query->where('cohort', $cohort);
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('student', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%")
                                ->orWhere('cohort', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get violations for specific student - Mahasiswa/Staff/Admin
     */
    public function getByStudent(int $userId): Collection
    {
        return Violation::with(['reporter'])
            ->byStudent($userId)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get total points for student (active violations only)
     */
    public function getTotalPoint(int $userId): int
    {
        return Violation::byStudent($userId)
            ->active()
            ->sum('point');
    }

    /**
     * Update violation
     */
    public function update(int $id, array $data): bool
    {
        $violation = Violation::findOrFail($id);

        // Only reporter or admin can update
        if (Auth::id() !== $violation->reported_by && auth()->user()->role !== 'admin') {
            throw new \Exception('Unauthorized');
        }

        return $violation->update($data);
    }

    /**
     * Delete violation
     */
    public function delete(int $id): bool
    {
        $violation = Violation::findOrFail($id);

        // Only reporter or admin can delete
        if (Auth::id() !== $violation->reported_by && auth()->user()->role !== 'admin') {
            throw new \Exception('Unauthorized');
        }

        return $violation->delete();
    }

    /**
     * Get violation by ID with relations
     */
    public function find(int $id)
    {
        return Violation::with(['student', 'reporter'])->findOrFail($id);
    }
}
