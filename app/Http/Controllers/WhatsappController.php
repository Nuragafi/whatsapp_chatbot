<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Dialog;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    function getToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (
                isset($_GET['hub_mode']) && $_GET['hub_mode'] === 'subscribe' && isset($_GET['hub_challenge']) &&
                isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === 'cobachatbot'
            ) {
                Log::info($_GET['hub_challenge']);
                Log::info($_GET['hub_verify_token']);
                Log::info($_GET['hub_mode']);

                echo $_GET['hub_challenge'];
            } else {
                http_response_code(403);
                Log::info('Invalid verification request');
            }
        }
    }

    function getMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $message = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'] ?? null;
            $from = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'] ?? null;
            $name = $data['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'] ?? null;

            if ($message && $from) {
                Log::info("Received message: $message from $from");
                $customer = Customer::firstOrCreate(
                    ['phone_number' => $from],
                    ['name' => $name ?: 'Unknown']
                );
                $checkHistory = $customer->histories()->where('created_at', '>=', now()->subMinutes(60))->latest()->first();

                if (!$checkHistory || $checkHistory->dialog_id === null) {
                    $reply = "Hallo {$name}, terima kasih sudah menghubungi Layanan Jasa Raharja Cirebon. Jam operasional Jasa Raharja Cirebon adalah Senin – Jumat (kecuali hari Libur Nasional) pukul 07.30-16.30 WIB.\n";
                    $dialog = Dialog::where('parent_id', null)->first();
                    $customer->histories()->create([
                        'created_at' => now(),
                        'step' => $message,
                        'dialog_id' => $dialog->id ?? null,
                    ]);
                    $reply .= $dialog->message;
                    $this->sendMessage($from, $reply);
                } else if ($message == 9) {
                    $lastHistory = History::where('customer_id', $customer->id)
                        ->orderBy('created_at', 'desc')
                        ->skip(1)
                        ->take(1)
                        ->first();
                    if ($lastHistory) {
                        $lastDialog = Dialog::where('id', $lastHistory->dialog_id)->first();
                        if ($lastDialog) {
                            $customer->histories()->create([
                                'created_at' => now(),
                                'step' => $lastDialog->step,
                                'dialog_id' => $lastDialog->id,
                            ]);
                        }
                        // Log::info("Last dialog: {$lastDialog->message}");
                        $this->sendMessage($from, $lastDialog->message);
                    } else {
                        Log::info("No previous history found for customer: {$customer->id}");
                        $this->sendMessage($from, 'Tidak ada riwayat sebelumnya');
                    }
                } else if ($checkHistory->dialog_id == 4) {
                    if ($message == 1) {
                        $dialog = 'Mohon menunggu, Petugas Jasa Raharja akan segera membantu Anda';
                        $dialog2 = 'Selamat Siang, Saat ini terhubung dengan Petugas Putri Perihal apa yang dapat kami bantu ?';
                        $customer->histories()->create([
                            'created_at' => now(),
                            'step' => $message,
                            'dialog_id' => 4,
                        ]);
                        $this->sendMessage($from, $dialog);
                        $this->sendMessage($from, $dialog2);
                    } else {
                        $dialog = "Mohon menunggu, kami akan lakukan pengecekan terlebih dahulu ya";
                        $dialog2 = "Kami menginformasikan bahaw untuk Surat Jaminan (Guarantee Letter) sudah kami terbitkan, silahkan di cek pada aplikasi di JR Care.";
                        $dialog3 = "Ada hal lain yang dapat kami bantu ?";
                        $this->sendMessage($from, $dialog);
                        $this->sendMessage($from, $dialog2);
                        $this->sendMessage($from, $dialog3);
                        $customer->histories()->create([
                            'created_at' => now(),
                            'step' => $message,
                            'dialog_id' => 10,
                        ]);
                    }
                } else if ($checkHistory->dialog_id == 10) {
                    $customer->histories()->create([
                        'created_at' => now(),
                        'step' => $message,
                        'dialog_id' => null,
                    ]);
                } else {
                    Log::info("History: $checkHistory, Dialog: {$checkHistory->dialog_id}");
                    $dialog = Dialog::where('step', $message)->where('parent_id', $checkHistory->dialog_id)->first();
                    Log::info("Dialog found: " . ($dialog ? 'Yes' : 'No'));
                    if ($dialog) {
                        $customer->histories()->create([
                            'created_at' => now(),
                            'step' => $message,
                            'dialog_id' => $dialog->id,
                        ]);
                    } else {
                        $dialog = Dialog::where('dialog_id', $checkHistory->dialog_id)->first();
                    }
                    $this->sendMessage($from, $dialog->message ?? '');
                }
            } else {
                Log::info('No message or sender information found');
            }
        } else {
            http_response_code(405);
            Log::info('Method not allowed');
        }
    }

    private function sendMessage($to, $text)
    {
        $token = 'EAAqEcSJsdi8BPKxyhbOy1VLCgsZCFGkLLovJu34HFGTODM7cSykqNe5LhPxRrZBuYlt39jHKXnvMQHw662WIAMZCSMhZCx6Obip274nC1oqjYMNlC8hjBa5K140DSZCEuczTJ6ZBVImtcDOLAUrPDpZCK01T2JsZC6g20igPfOugBwzZA13eq7o25oO6Vm3eEm98BEuAavCUH03z38vfqZCQb1TJNXy88sHwmlGmTDK8ep91HaQAZDZD';
        $phone_id = '689730917563054';

        $url = "https://graph.facebook.com/v22.0/{$phone_id}/messages";

        Http::withToken($token)->post("$url", [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => ['body' => $text],
        ]);
    }
}
