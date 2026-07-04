<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = [
            'avatars/I1.jpg',
            'avatars/I2.jpg',
            'avatars/I3.jpg',
            'avatars/I4.jpg',
            'avatars/I5.jpg',
            'avatars/IMG-20231111-WA0029.jpg',
            'avatars/IMG-20241106-WA0018.jpg',
            'avatars/IMG-20250319-WA0003.jpg',
            'avatars/IMG-20250606-WA0016.jpg',
            'avatars/IMG-20250606-WA0018.jpg',
            'avatars/IMG-20250606-WA0052.jpg',
            'avatars/user10.jpg',
        ];

        // Well-known demo account for testing the storefront.
        $this->createBackdated('customer@example.com', 'Demo Customer', $avatars[0], Carbon::now()->subDays(40));

        $names = [
            'Amina Hassan', 'Bashir Omar', 'Cynthia Nabatanzi', 'David Kato',
            'Esther Nakato', 'Farah Abdi', 'Grace Namutebi', 'Hussein Ali',
            'Irene Achieng', 'John Mugisha', 'Khadija Noor', 'Lydia Auma',
            'Musa Ibrahim', 'Nadia Yusuf', 'Peter Ssentamu',
        ];

        foreach ($names as $index => $name) {
            $email = strtolower(str_replace(' ', '.', $name)).'@example.com';

            // Spread signups over the last ~55 days, with the most recent
            // couple of accounts landing "today" so the dashboard's
            // "new users today" widget has something to show.
            $createdAt = $index < 2
                ? Carbon::today()->addHours($index)
                : Carbon::now()->subDays(3 + $index * 4);

            $this->createBackdated($email, $name, $avatars[($index + 1) % count($avatars)], $createdAt);
        }
    }

    private function createBackdated(string $email, string $name, string $avatar, Carbon $createdAt): void
    {
        if (User::where('email', $email)->exists()) {
            return;
        }

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => 'password',
            'avatar' => $avatar,
        ]);

        $user->timestamps = false;
        $user->created_at = $createdAt;
        $user->updated_at = $createdAt;
        $user->save();
    }
}
