<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\ActivityLog;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ZipArchive;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // $this->middleware('permission:Delete Invoices')->only('delete');
    }
    public function delete($id)
    {
        // $invoice = Invoice::find($id);
        // $invoice->delete();

        // ActivityLog::create([
        //     'user_id' => auth()->user()->id,
        //     'payload' => "Deleted Invoice No. $invoice->id"
        // ]);

        // $this->emit('done', [
        //     'success' => 'Successfully Deleted the Invoice'
        // ]);
        $this->emit('done', [
            'info' => 'Invoice Deletion has now been disabled'
        ]);
    }

    public function render()
    {

        return view('livewire.admin.invoices.index', [
            'invoices' => Invoice::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function downloadInvoices()
    {

        foreach (Invoice::all() as $invoice) {
            $pdf = Pdf::loadView('documents.invoice', [
                'invoice' => $invoice
            ]);
            $pdf->render();
            $date = Carbon::parse($invoice->created_at)->toDateString();
            $pdfFileName = $date . '- RICNEL - Invoice # ' . $invoice->id . '.pdf';

            $pdf->save('invoices/' . $pdfFileName, 'public');
        }

        $zip_file = 'invoices_' . Carbon::now()->getTimestamp() . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path = 'invoices';
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = 'invoices/' . $name;

                $zip->addFile($filePath, $relativePath);
            }
        }



        $zip->close();
        $this->deleteDirectory(public_path('invoices'));
        return response()->download($zip_file)->deleteFileAfterSend(true);
    }


    public function deleteDirectory($directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        $files = array_diff(scandir($directory), ['.', '..']);

        foreach ($files as $file) {
            $filePath = $directory . '/' . $file;

            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }

        rmdir($directory);
    }
}
