<?php

use App\User;
use App\Models\Status;
use App\Models\Friendship;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Status::truncate();
        $gary = factory(User::class)->create(['name' => 'Gary', 'email' => 'asd@asd.com']);
        $asd = factory(User::class)->create(['email' => 'asd@mail.com']);
        factory(Status::class,20)->create();
        factory(Friendship::class)->create([
          'recipient_id' => $gary->id,
          'sender_id' => $asd->id
        ]);
    }
}
