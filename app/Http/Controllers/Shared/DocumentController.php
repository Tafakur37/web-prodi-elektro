<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Helpers\PermissionHelper;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;

/**
 * =============================================================================
 * SHARED DOCUMENT CONTROLLER — SIMelek
 * =============================================================================
 *
 * Controller tunggal untuk fitur Surat & Dokumen yang digunakan oleh semua role.
 * Akses dikontrol via PermissionHelper — tidak perlu controller duplikat per role.
 *
 * Route yang menggunakan controller ini:
 *   - admin.documents.*
 *   - staff.documents.*
 *   (mahasiswa menggunakan SubmissionController karena view berbeda)
 *
 * Permission check:
 *   - index    : view_all (staff, sesprodi, kaprodi) atau view_own
 *   - store    : create
 *   - destroy  : delete (admin only)
 *   - approve  : approve (staff, sesprodi, kaprodi)
 * =============================================================================
 */
class DocumentController extends Controller
{
    public function __construct(private DocumentService $documentService) {}

    /**
     * Tampilkan daftar dokumen berdasarkan permission user.
     */
    public function index()
    {
        PermissionHelper::canOrAbort('documents', 'view_all');

        $role = auth()->user()->role;

        // Admin: lihat semua dokumen (dari semua user)
        if ($role === 'admin') {
            $incomingDocuments = $this->documentService->getIncomingForAdmin();
        } else {
            // Staff/sesprodi/kaprodi: lihat dokumen masuk untuk role mereka
            $incomingDocuments = $this->documentService->getIncoming($role);
        }

        $myDocuments = $this->documentService->getMyDocuments(auth()->id());

        // Tentukan view berdasarkan role — admin punya view khusus, staff pakai view mereka
        $view = ($role === 'admin') ? 'admin.documents.index' : 'staff.documents.index';

        // Inject permission flags untuk view
        $permissions = [
            'canApprove' => PermissionHelper::can('documents', 'approve'),
            'canDelete'  => PermissionHelper::can('documents', 'delete'),
            'canExport'  => PermissionHelper::can('documents', 'export'),
        ];

        return view($view, compact('incomingDocuments', 'myDocuments', 'permissions'));
    }

    /**
     * Simpan dokumen baru.
     */
    public function store(Request $request)
    {
        PermissionHelper::canOrAbort('documents', 'create');

        $request->validate([
            'title'         => 'required|string|max:255',
            'category'      => 'required|in:surat,berkas',
            'receiver_role' => 'required|in:dosen,staff,admin,sesprodi,kaprodi',
            'file'          => 'required|mimes:pdf,doc,docx,zip|max:5120',
            'description'   => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('file')) {
            $this->documentService->store($request->all(), $request->file('file'), auth()->id());
            return redirect()->back()->with('success', 'Dokumen berhasil dikirim!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Download dokumen.
     */
    public function download(Document $document)
    {
        // Cek: user hanya bisa download dokumen miliknya, kecuali admin/staff
        if (!PermissionHelper::can('documents', 'view_all')) {
            if ($document->user_id !== auth()->id()) {
                abort(403, 'Anda tidak boleh mengunduh dokumen ini.');
            }
        }

        $response = $this->documentService->download($document);

        if (!$response) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $response;
    }

    /**
     * Approve atau reject dokumen.
     */
    public function updateStatus(Request $request, Document $document)
    {
        PermissionHelper::canOrAbort('documents', 'approve');

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note'   => 'nullable|string|max:500',
        ]);

        $document->update([
            'status' => $request->status,
            'note'   => $request->note,
        ]);

        $statusLabel = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('success', "Dokumen berhasil {$statusLabel}.");
    }

    /**
     * Hapus dokumen (admin only).
     */
    public function destroy(Document $document)
    {
        PermissionHelper::canOrAbort('documents', 'delete');

        $this->documentService->destroy($document);
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
