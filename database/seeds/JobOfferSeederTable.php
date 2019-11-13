<?php

use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(JobOffer::class, 20)->create();
    }
}
