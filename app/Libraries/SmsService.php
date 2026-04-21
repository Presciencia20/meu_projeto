<?php

namespace App\Libraries;

/**
 * SmsService — Abstracção para envio de SMS em Angola.
 *
 * Configurar no .env:
 *   SMS_FAKE=true          → Modo desenvolvimento (sem custo, código visível nos logs)
 *   SMS_PROVIDER=twilio    → Ou "infobip", "smsconexao"
 *   TWILIO_SID=ACxxxxxxxx
 *   TWILIO_TOKEN=xxxxxxxx
 *   TWILIO_FROM=+244xxxxxxxx
 */
class SmsService
{
    protected bool   $fakeMode;
    protected string $provider;

    public function __construct()
    {
        $this->fakeMode = (bool) env('SMS_FAKE', true);
        $this->provider = env('SMS_PROVIDER', 'twilio');
    }

    /**
     * Envia um SMS para o número indicado.
     * Em modo FAKE, grava o código nos logs e em session flash para mostrar na UI.
     *
     * @param string $phone   Número de destino (ex: +244923456789)
     * @param string $message Mensagem a enviar
     * @return bool
     */
    public function send(string $phone, string $message): bool
    {
        if ($this->fakeMode) {
            log_message('notice', "[SMS FAKE] Para: {$phone} | Mensagem: {$message}");

            // Guarda em flash para mostrar na UI durante desenvolvimento
            session()->setFlashdata('dev_sms', "[DEV MODE] SMS para {$phone}: {$message}");

            return true;
        }

        return match ($this->provider) {
            'twilio'    => $this->sendViaTwilio($phone, $message),
            'infobip'   => $this->sendViaInfobip($phone, $message),
            default     => false,
        };
    }

    // -------------------------------------------------------------------------
    // Providers
    // -------------------------------------------------------------------------

    protected function sendViaTwilio(string $phone, string $message): bool
    {
        $sid   = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from  = env('TWILIO_FROM');

        if (! $sid || ! $token || ! $from) {
            log_message('error', '[SmsService] Credenciais Twilio não configuradas.');
            return false;
        }

        $url  = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        $data = http_build_query([
            'From' => $from,
            'To'   => $phone,
            'Body' => $message,
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => "{$sid}:{$token}",
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201) {
            return true;
        }

        log_message('error', "[SmsService] Twilio erro {$httpCode}: {$response}");
        return false;
    }

    protected function sendViaInfobip(string $phone, string $message): bool
    {
        $apiKey  = env('INFOBIP_API_KEY');
        $baseUrl = env('INFOBIP_BASE_URL'); // ex: xxxxx.api.infobip.com

        if (! $apiKey || ! $baseUrl) {
            log_message('error', '[SmsService] Credenciais Infobip não configuradas.');
            return false;
        }

        $payload = json_encode([
            'messages' => [[
                'destinations' => [['to' => $phone]],
                'from'         => 'CasaSegura',
                'text'         => $message,
            ]],
        ]);

        $ch = curl_init("https://{$baseUrl}/sms/2/text/advanced");
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                "Authorization: App {$apiKey}",
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return true;
        }

        log_message('error', "[SmsService] Infobip erro {$httpCode}: {$response}");
        return false;
    }

    // -------------------------------------------------------------------------
    // Helper: formatar número angolano para E.164
    // -------------------------------------------------------------------------

    /**
     * Normaliza número do formato "923456789" ou "0923456789"
     * para "+244923456789".
     */
    public static function normalizeAngolan(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '244')) {
            return '+' . $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '+244' . substr($phone, 1);
        }

        return '+244' . $phone;
    }
}
