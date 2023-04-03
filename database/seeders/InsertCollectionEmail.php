<?php

namespace Database\Seeders;

use App\Models\CollectionEmail;
use Illuminate\Database\Seeder;

class InsertCollectionEmail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'C10MS00004';
        $collectionEmail->broker_name = 'Mahkota Sentosa Utama';
        $collectionEmail->pic_on_system = 'irene putri';
        $collectionEmail->pic_emailed_by_finance = 'legina.wijaya@meikarta.com; Christian.rondonuwu@meikarta.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10AA00031';
        $collectionEmail->broker_name = 'Adi Antara Asia';
        $collectionEmail->pic_on_system = 'Joseph';
        $collectionEmail->pic_emailed_by_finance = 'budi@aaa-brokingservices.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10DI00001';
        $collectionEmail->broker_name = 'DSR Insurance Broker';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'jane.rondonuwu@dsrbroker.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10DP00007';
        $collectionEmail->broker_name = 'Dinda Pradana Insurance Broker';
        $collectionEmail->pic_on_system = 'Bpk Chrisna Sebayang/ Ibu Erni';
        $collectionEmail->pic_emailed_by_finance = 'jhonson@dpib.co.id; erni@dpib.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10DU00001';
        $collectionEmail->broker_name = 'DAIDAN UTAMA PIALANG ASURANSI';
        $collectionEmail->pic_on_system = 'ANDRE';
        $collectionEmail->pic_emailed_by_finance = 'finance@dupa.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10HI00003';
        $collectionEmail->broker_name = 'Howden Insurance Brokers Indonesia';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'vera.fabiana@id.howdengroup.com; arata.hirnoveria@id.howdengroup.com; meini.irawati@id.howdengroup.com; denni.wijaya@id.howdengroup.com; yuanna.hanjaya@id.howdengroup.com; eko.maryanto@id.howdengroup.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10LC00002';
        $collectionEmail->broker_name = 'Lestari Cipta Hokindo';
        $collectionEmail->pic_on_system = 'Tan Bee Leng (Komisaris Utama)';
        $collectionEmail->pic_emailed_by_finance = 'adminfin@ciptahokindo.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PA00016';
        $collectionEmail->broker_name = 'Aon Indonesia';
        $collectionEmail->pic_on_system = 'Novarianto Anggoro';
        $collectionEmail->pic_emailed_by_finance = 'novarianto.anggoro@aon.com; inda.mastini@aon.com; yandy.ramlan@aon.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PI00014';
        $collectionEmail->broker_name = 'Premier Investama Bersama';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'exiana@premier-broker.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PJ00001';
        $collectionEmail->broker_name = 'Jaya Proteksindo Sakti';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'collection1@jayaproteksindo.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PK00002';
        $collectionEmail->broker_name = 'Kalibesar Raya Utama - Insurance Broker';
        $collectionEmail->pic_on_system = 'Bp. Wendi Bimo atau Andi Santoso';
        $collectionEmail->pic_emailed_by_finance = 'catherine@kbru.co.id; collection@kbru.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PM00002';
        $collectionEmail->broker_name = 'Marsh Indonesia';
        $collectionEmail->pic_on_system = 'Megantara Susetyo';
        $collectionEmail->pic_emailed_by_finance = 'Ian-Dwi.Alviana@marsh.com; febrehane.sabattini@mmc.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PM00004';
        $collectionEmail->broker_name = 'Mitra Iswara & Rorimpandey, Ltd';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'hendri.cahyadi@mirbrokers.com; faisal.suwarno@mirbrokers.com; romi.batuginta.tarigan@mirbrokers.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PP00019';
        $collectionEmail->broker_name = 'PT Proteksi Jaya Mandiri';
        $collectionEmail->pic_on_system = 'Ahmad Priyadhi Putranto (Direksi)';
        $collectionEmail->pic_emailed_by_finance = 'resa.pangestu@pjmbroker.com; Dian.Trianasari@pjmbroker.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10PW00003';
        $collectionEmail->broker_name = 'Willis Indonesia';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'irna.husdiar@WillisTowersWatson.com; AdeRizky.Novitasari@willistowerswatson.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10SU00071';
        $collectionEmail->broker_name = 'Sukses Utama Sejahtera';
        $collectionEmail->pic_on_system = 'Sonny';
        $collectionEmail->pic_emailed_by_finance = 'inka@susindo.com;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10TI00005';
        $collectionEmail->broker_name = 'Tugu Insurance Broker ';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'thata.tugubro@gmail.com; sugiarso@tib.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10TI00007';
        $collectionEmail->broker_name = 'Talisman Insurance Brokers';
        $collectionEmail->pic_on_system = '';
        $collectionEmail->pic_emailed_by_finance = 'fellytia.anjeli@talisman.co.id;';
        $collectionEmail->save();

        $collectionEmail = new CollectionEmail;
        $collectionEmail->id_profile = 'M10BP00111';
        $collectionEmail->broker_name = 'Barron Pandu Abadi';
        $collectionEmail->pic_on_system = 'Muhammad Kademang';
        $collectionEmail->pic_emailed_by_finance = 'uswatun.khasanah@bpabrokers.co.id;';
        $collectionEmail->save();
    }
}
