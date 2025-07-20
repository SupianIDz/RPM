<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BrandSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run() : void
    {
        $this->brands()->each(function (string $site, string $name) {
            $brand = \App\Brand\Models\Brand::create([
                'name' => $name,
                'site' => $site,
            ]);

            $brand->update([
                'logo' => md5($brand->slug) . '.png',
            ]);
        });
    }

    /**
     * @return Collection
     */
    private function brands() : Collection
    {
        return collect([
            // OEM & Genuine Parts
            'Astra Otoparts'   => 'https://www.astra-otoparts.com',
            'Federal Parts'    => 'https://www.federatedautoparts.com',
            'YGP'              => 'https://yamaha-motor.com',
            'HGP'              => 'https://www.astra-honda.com',
            'SGP'              => 'https://suzuki.co.id',
            'KGP'              => 'https://www.kawasaki-motor.co.id',
            'VND'              => 'https://www.vnd.co.id',

            // Oli & Pelumas
            'Federal Oil'      => 'https://www.federaloil.co.id',
            'Yamalube'         => 'https://yamahaonlineparts.com',
            'AHM Oil'          => 'https://www.astra-honda.com',
            'Shell'            => 'https://www.shell.com',
            'Motul'            => 'https://www.motul.com',
            'Castrol'          => 'https://www.castrol.com',
            'Top 1'            => 'https://www.top1.co.id',
            'Pertamina Enduro' => 'https://www.endurooil.com',
            'Repsol'           => 'https://www.repsol.com',

            // Aki / Battery
            'GS Astra'         => 'https://www.astra-otoparts.com',
            'Yuasa'            => 'https://www.yuasa.com',
            'Incoe'            => 'https://www.incoe.co.id',
            'Motobatt'         => 'https://www.motobatt.com',
            'Bosch Battery'    => 'https://www.boschautoparts.com',

            // Busi
            'NGK'              => 'https://www.ngkntk.com',
            'Denso'            => 'https://www.denso.com/global',
            'Bosch'            => 'https://www.boschautoparts.com',

            // Kampas Rem, Kopling, dll
            'Aspira'           => 'https://www.astra-otoparts.com',
            'SBS'              => 'https://www.sbscorporation.co.kr',
            'TDR'              => 'https://www.tdr-racing.com',
            'Ferrodo'          => 'https://www.ferrodo.com',
            'Daytona'          => 'https://www.daytona-moto.com',
            'Exedy'            => 'https://www.exedy.com',

            // CVT, V-belt, Roller
            'Bando'            => 'https://www.bando.com',
            'Mitsuboshi'       => 'https://www.mitsuboshi.co.jp',
            'Aspira Premio'    => 'https://www.astra-otoparts.com',

            // Shock & Suspensi
            'YSS'              => 'https://yss.com',
            'KTC'              => 'https://www.ktc.co.jp',
            'Racing Boy (RCB)' => 'https://www.racingboy.com.my',
            'Showa'            => 'https://www.showa-grp.co.jp',
            'Kayaba (KYB)'     => 'https://www.kyb.com',

            // Ban Motor
            'IRC'              => 'https://www.irc-tire.com',
            'FDR'              => 'https://www.fdr.co.id',
            'Corsa'            => 'https://www.corsatimor.com',
            'Michelin'         => 'https://www.michelin.com',
            'Pirelli'          => 'https://www.pirelli.com',
            'Bridgestone'      => 'https://www.bridgestone.com',
            'Swallow'          => 'https://www.swallow-tire.com',
            'Zeneos'           => 'https://www.zeneostire.com',
            'Maxxis'           => 'https://www.maxxis.com',

            // Rantai & Gear
            'TK Racing'        => 'https://www.tkracingchain.com',
            'SSS'              => 'https://www.sss-chain.co.jp',
            'Triple S'         => 'https://www.sss-chain.co.jp',
            'DID'              => 'https://www.didchain.com',
            'RK Takasago'      => 'https://www.rkexcelchain.com',

            // Lampu & Kelistrikan
            'Osram'            => 'https://www.osram.com',
            'Philips'          => 'https://www.philips.com/automotive',
            'Autovision'       => 'https://www.autovision.co.id',
        ]);
    }
}
