<?php

namespace Modules\Voucher\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Voucher\Entities\Voucher;

class VoucherDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Voucher::factory()->count(5)->create();

        // $voucher = Voucher::factory()->make();
        // dd($voucher->toArray());
        // $this->call("OthersTableSeeder");
    }
}
