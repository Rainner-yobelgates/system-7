<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public function generateReceipt($id)
    {
        $data = Transaction::findOrFail($id);
        $setting = Setting::first();
        $pdf = Pdf::loadView('pdf.receipt', compact('data', 'setting'));

        $fileName = 'receipt_' . Str::slug((string) $data->nama, '_') . '.pdf';

        return $pdf->download($fileName);
    }
}
