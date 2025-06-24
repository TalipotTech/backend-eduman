<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Cashier\Order\Order;
use URL;
use Exception;
use Mail;
use Mpdf\MpdfException;
use Storage;
use ZipArchive;
use Illuminate\Support\Str;

use App\Helpers\Pdf;
use App\Mail\Ordered;
use App\Mail\Paid;
use App\Mail\Exported;
use App\Models\OrderItem;
use Carbon\Carbon;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Throwable;


final class PdfGeneratorController extends Controller
{

    /**
     * @param $orderId
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function GenerateOrderInvoices($orderId) 
    {
        $order = Order::find($orderId);

        $storage = Storage::disk('local');
        $storage->makeDirectory('invoices');

        $content = Pdf::generate(
            Str::slug(__('Invoice').' '.$order->id),
            view('pdf.invoice', ['order' => $order])->render(),
            view('pdf.header')->render(),
            view('pdf.footer')->render()
        );

        $file = 'invoices'.DIRECTORY_SEPARATOR.$order->id.'.pdf';

        $storage->put($file, encrypt($content));

        Mail::to(optional($order->customer)->email)
            ->send(new Paid($order, $file));

        Mail::to('nasir.chalo@gmail.com')
            ->send(new Ordered($order, $file));

        return response()->json([
            'success' => true,
            'status' => 'success',
        ]);
    }
    
}
