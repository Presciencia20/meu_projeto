<?php

namespace App\Libraries;

/**
 * TwilioVerifyService — Serviço de verificação via Twilio Verify.
 *
 * Configurar no .env:
 *   TWILIO_SID=ACxxxxxxxx                                    → Account SID
 *   TWILIO_TOKEN=xxxxxxxx                                    → Auth Token
 *   TWILIO_VERIFY_SERVICE_SID=VAxxxxxxxx                     → Verify Service SID
 *   TWILIO_VERIFY_ENABLED=true|false                         → Ativar/desativar
 *
 * Endpoints utilizados:
 *   POST https://verify.twilio.com/v2/Services/{SERVICE_SID}/Verifications
 *   POST https://verify.twilio.com/v2/Services/{SERVICE_SID}/VerificationCheck
 */
class TwilioVerifyService
{
    protected ?string $sid;
    protected ?string $token;
    protected ?string $serviceSid;
    protected bool   $enabled;
    protected string $baseUrl = 'https://verify.twilio.com/v2';

    public function __construct()
    {
        $this->sid       = env('TWILIO_SID');
        $this->token     = env('TWILIO_TOKEN');
        $this->serviceSid = env('TWILIO_VERIFY_SERVICE_SID');
        $this->enabled   = (bool) env('TWILIO_VERIFY_ENABLED', false);
    }

    /**
     * Inicia uma verificação, enviando um código para o número indicado.
     *
     * @param string $phone Número de destino em formato internacional (ex: +244923456789)
     * @param string $channel 'sms' ou 'call' (padrão: 'sms')
     * @return array|false Array com sid, status, etc. ou false se falhar
     */
    public function sendCode(string $phone, string $channel = 'sms'): array|false
    {
        if (!$this->enabled || !$this->serviceSid) {
            log_message('warning', '[TwilioVerifyService] Serviço não configurado ou desabilitado.');
            return false;
        }

        $url = "{$this->baseUrl}/Services/{$this->serviceSid}/Verifications";
        
        $data = http_build_query([
            'To'      => $phone,
            'Channel' => $channel,
        ]);

        $response = $this->_makeRequest('POST', $url, $data);

        if ($response === false) {
            return false;
        }

        $decoded = json_decode($response, true);

        if (!$decoded || !isset($decoded['sid'])) {
            log_message('error', '[TwilioVerifyService] Resposta inválida ao enviar código: ' . $response);
            return false;
        }

        return $decoded;
    }

    /**
     * Verifica se o código enviado é válido.
     *
     * @param string $phone Número de destino em formato internacional
     * @param string $code Código de verificação (ex: 123456)
     * @return array|false Array com status='approved' se válido, ou false se falhar
     */
    public function verifyCode(string $phone, string $code): array|false
    {
        if (!$this->enabled || !$this->serviceSid) {
            log_message('warning', '[TwilioVerifyService] Serviço não configurado ou desabilitado.');
            return false;
        }

        $url = "{$this->baseUrl}/Services/{$this->serviceSid}/VerificationCheck";
        
        $data = http_build_query([
            'To'   => $phone,
            'Code' => $code,
        ]);

        $response = $this->_makeRequest('POST', $url, $data);

        if ($response === false) {
            return false;
        }

        $decoded = json_decode($response, true);

        if (!$decoded) {
            log_message('error', '[TwilioVerifyService] Resposta inválida ao validar código: ' . $response);
            return false;
        }

        // Retornar true se status é 'approved'
        if (isset($decoded['status']) && $decoded['status'] === 'approved') {
            return $decoded;
        }

        log_message('notice', '[TwilioVerifyService] Código inválido para ' . $phone . '. Status: ' . ($decoded['status'] ?? 'desconhecido'));
        return false;
    }

    /**
     * Cancela uma verificação em andamento.
     *
     * @param string $phone Número de destino
     * @return bool true se bem-sucedido
     */
    public function cancelVerification(string $phone): bool
    {
        if (!$this->enabled || !$this->serviceSid) {
            return false;
        }

        $url = "{$this->baseUrl}/Services/{$this->serviceSid}/Verifications/{$phone}";
        
        $data = http_build_query(['Status' => 'canceled']);

        $response = $this->_makeRequest('POST', $url, $data);

        return $response !== false;
    }

    /**
     * Executa uma requisição HTTP autenticada ao Twilio Verify API.
     *
     * @param string $method 'GET' ou 'POST'
     * @param string $url URL completa do endpoint
     * @param string|null $data Dados POST a enviar
     * @return string|false Resposta JSON ou false se erro
     */
    protected function _makeRequest(string $method, string $url, ?string $data = null): string|false
    {
        $ch = curl_init($url);
        
        $curlOps = [
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => "{$this->sid}:{$this->token}",
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 10,
        ];

        if ($method === 'POST' && $data) {
            $curlOps[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($ch, $curlOps);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            log_message('error', "[TwilioVerifyService] CURL erro: {$curlError}");
            return false;
        }

        // Verificar status HTTP
        if (!in_array($httpCode, [200, 201])) {
            log_message('error', "[TwilioVerifyService] HTTP {$httpCode}: {$response}");
            return false;
        }

        return $response;
    }

    /**
     * Verifica se o serviço está habilitado.
     */
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->serviceSid);
    }
}
