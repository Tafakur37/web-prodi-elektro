<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct(private DocumentService $documentService) {}

    public function index()
    {
        $incomingDocuments = $this->documentService->getIncoming('staff');
        $myDocuments = $this->documentService->getMyDocuments(auth()->id());

        return view('staff.documents.index', compact('incomingDocuments', 'myDocuments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:surat,berkas',
            'receiver_role' => 'required|in:dosen,staff,admin,sesprodi,kaprodi',
            'file' => 'required|mimes:pdf,doc,docx,zip|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $this->documentService->store($request->all(), $request->file('file'), auth()->id());
            return redirect()->back()->with('success', 'Dokumen berhasil dikirim!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function download(Document $document)
    {
        $response = $this->documentService->download($document);

        if (!$response) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $response;
    }

    public function destroy(Document $document)
    {
        $this->documentService->destroy($document);
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}