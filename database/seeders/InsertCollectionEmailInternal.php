<?php

namespace Database\Seeders;

use App\Models\CollectionEmailInternal;
use Illuminate\Database\Seeder;

class InsertCollectionEmailInternal extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CollectionEmailInternal = new CollectionEmailInternal();
        $CollectionEmailInternal->email = 'yekti@lippoinsurance.com';
        $CollectionEmailInternal->save();

        $CollectionEmailInternal = new CollectionEmailInternal();
        $CollectionEmailInternal->email = 'rinto@lippoinsurance.com';
        $CollectionEmailInternal->save();

        $CollectionEmailInternal = new CollectionEmailInternal();
        $CollectionEmailInternal->email = 'finance01.ho@lippoinsurance.com';
        $CollectionEmailInternal->save();

        $CollectionEmailInternal = new CollectionEmailInternal();
        $CollectionEmailInternal->email = 'finance02.karawaci@lippoinsurance.com';
        $CollectionEmailInternal->save();

        $CollectionEmailInternal = new CollectionEmailInternal();
        $CollectionEmailInternal->email = 'finance07.ho@lippoinsurance.com';
        $CollectionEmailInternal->save();
    }
}