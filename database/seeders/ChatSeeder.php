<?php

namespace Database\Seeders;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\User; // Assuming you have a User model
use Illuminate\Database\Seeder;

// php artisan db:seed --class=ChatSeeder
class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are some users to associate with chat sessions
        if (User::count() === 0) {
            User::factory()->count(3)->create(); // Create 3 dummy users if none exist
        }

        // Get all users
        $users = User::all();

        // Create chat sessions and messages for each user
        foreach ($users as $user) {
            // Create 2-3 chat sessions per user
            try{
                for ($i = 0; $i < rand(2, 3); $i++) {
                    $session = ChatSession::create([
                        'user_id' => $user->id,
                        'title' => 'Chat with LLM ' . ($i + 1) . ' for ' . $user->name,
                    ]);
    
                    // Create 5-10 messages per session
                    for ($j = 0; $j < rand(5, 10); $j++) {
                        // Alternate sender type between 'user' and 'llm'
                        $senderType = ($j % 2 === 0) ? 'user' : 'llm';
                        $content = ($senderType === 'user' ? 'User message ' : 'LLM response ') . ($j + 1) . ' in session ' . $session->id;
    
                        ChatMessage::create([
                            'chat_session_id' => $session->id,
                            'sender_type' => $senderType,
                            'content' => $content,
                        ]);
                    }
                }
            }catch(\Exception $e){
                preout($e->getMessage());
            }
        }
    }
}

