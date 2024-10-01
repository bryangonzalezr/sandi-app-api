<?php

namespace Tests\Feature;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;

use Tests\TestCase;

class ChatMessageTest extends TestCase
{

    public function test_users_can_send_message_in_chat(): void
    {
        Event::fake([
            MessageSent::class
        ]);

        $sender = User::find(3);
        $receiver = User::find(4);

        $this->actingAs($sender);

        $response = $this->postJson(route('chat.sendMessage', ['user' => $receiver->id]), [
            'message' => 'Hola, este es un mensaje de prueba.'
        ]);

        // Verificar que el mensaje fue creado correctamente
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message'
                 ]);

        // Verificar que el mensaje existe en la base de datos
        $this->assertDatabaseHas('chat_messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'text' => 'Hola, este es un mensaje de prueba.'
        ]);

        // Verificar que el evento MessageSent fue emitido correctamente
        Event::assertDispatched(MessageSent::class, function ($event) use ($sender, $receiver) {
            return $event->message->sender_id === $sender->id
                && $event->message->receiver_id === $receiver->id
                && $event->message->text === 'Hola, este es un mensaje de prueba.';
        });
    }

    /**
     * Test fetching messages between users.
     */
    public function test_user_can_fetch_messages()
    {
        $sender = User::find(3);
        $receiver = User::find(4);

        // Crear mensajes de prueba entre los usuarios
        ChatMessage::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'text' => 'Este es el primer mensaje'
        ]);

        ChatMessage::factory()->create([
            'sender_id' => $receiver->id,
            'receiver_id' => $sender->id,
            'text' => 'Este es el segundo mensaje'
        ]);

        // Actuar como el usuario remitente
        $this->actingAs($sender);

        // Simular la obtención de mensajes
        $response = $this->getJson(route('chat.getMessage', ['user' => $receiver->id]));
        // Verificar que se obtienen los mensajes correctamente
        $response->assertStatus(200);
    }
}
