<?php

namespace App\Http\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;

class QRCodeController extends Controller
{
    public function generate($id)
    {
        $url = url("/peminjaman/detail/$id"); // langsung ke detail peminjaman

        $qrCode = QrCode::create($url)
            ->setSize(300)
            ->setMargin(10)
            ->setEncoding(new Encoding('UTF-8'));

        $writer = new SvgWriter();
        $result = $writer->write($qrCode);

        // hasil QR Code dalam format data URI (langsung bisa ditaruh di <img src="">)
        $qr = $result->getDataUri();

        return view('admin.peminjaman.qr', compact('qr', 'url'));
    }
}
