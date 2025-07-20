<?php

namespace App\Brand\Console\Commands;

use App\Brand\Models\Brand;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GenerateLogoCommand extends Command
{
    protected $signature = 'rpm:brand:logo';

    protected $description = 'Generate brand logo';

    /**
     * @return void
     * @throws ConnectionException
     */
    public function handle() : void
    {
        $this->components->info('GENERATING BRAND LOGO...');

        $total = Brand::count();
        Brand::get()->each(function (Brand $brand, $number) use ($total) {
            $task = sprintf('[%s/%s] %s', str_pad($number + 1, strlen($total), '0', STR_PAD_LEFT), $total, strtoupper($brand->name));

            $this->components->task($task, function () use ($brand) {
                if (! $brand->logo) {
                    $name = md5($brand->slug) . '.png';
                    $store = Storage::disk('brand:logo')->put($name, $this->fetch($brand));

                    if ($store) {
                        $brand->update([
                            'logo' => $name,
                        ]);
                    }
                }
            });
        });
    }

    /**
     * @throws ConnectionException
     */
    private function fetch(Brand $brand) : string
    {
        $site = parse_url($brand->site, PHP_URL_HOST);

        return Http::get('https://img.logo.dev/' . $site . '?token=' . config('logodev.key'))->body();
    }
}
