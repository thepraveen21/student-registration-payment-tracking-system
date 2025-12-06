<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:generate {count=50}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR codes and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->argument('count');
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        // Using the facade instead of instantiating
        
        for ($i = 1; $i <= $count; $i++) {
            $code = 'QR' . str_pad($i, 5, '0', STR_PAD_LEFT);
            
            // Generate QR code image
            $qrImage = QrCode::format('svg')
                             ->size(300)
                             ->generate($code);
            
            // Save QR code image
            $imagePath = 'qrcodes/' . $code . '.svg';
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0777, true);
            }
            file_put_contents(public_path($imagePath), $qrImage);
            
            // Save to database
            \App\Models\QRCode::create([
                'code' => $code,
                'qr_image_path' => $imagePath,
                'is_assigned' => false
            ]);
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('QR codes generated successfully!');
    }
}
