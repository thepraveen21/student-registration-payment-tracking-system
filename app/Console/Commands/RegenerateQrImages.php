<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QRCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrFacade;

class RegenerateQrImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:regenerate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate QR image files so they encode the full URL (so scanners open the correct page)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $qrs = QRCode::all();
        if ($qrs->isEmpty()) {
            $this->info('No QR codes found.');
            return 0;
        }

        $bar = $this->output->createProgressBar($qrs->count());
        $bar->start();

        foreach ($qrs as $qr) {
            $url = rtrim(config('app.url'), '/') . '/qr/' . $qr->code;

            $svg = QrFacade::format('svg')
                ->size(300)
                ->generate($url);

            $path = public_path($qr->qr_image_path);
            $dir = dirname($path);
            if (! file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents($path, $svg);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('QR images regenerated to encode full URLs.');
        return 0;
    }
}
