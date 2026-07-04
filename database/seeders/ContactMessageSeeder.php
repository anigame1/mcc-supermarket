<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            ['name' => 'Sarah Nakimuli', 'email' => 'sarah.n@example.com', 'message' => 'Do you deliver to Kasanga on weekends?'],
            ['name' => 'Tom Okello', 'email' => 'tom.okello@example.com', 'message' => 'The mobile money payment option is great, thank you!'],
            ['name' => 'Ruth Adeyemi', 'email' => 'ruth.a@example.com', 'message' => 'Could you please restock the cooking oil? It sold out fast.'],
        ];

        foreach ($messages as $message) {
            ContactMessage::firstOrCreate($message);
        }
    }
}
