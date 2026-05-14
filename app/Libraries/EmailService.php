<?php

namespace App\Libraries;

/**
 * Serviço simulado de envio de Email para OTP.
 * Em produção, este serviço usaria a classe Email do CodeIgniter ou um provedor externo.
 */
class EmailService
{
    /**
     * Simula o envio de um email de verificação.
     */
    public function sendOtp(string $to, string $code): bool
    {
        $subject = "Código de Verificação - CasaSegura";
        $message = "O seu código de verificação é: $code\n\nEste código expira em 5 minutos.";
        
        // Em desenvolvimento, registamos no log
        log_message('info', "EMAIL_OTP para $to: $message");
        
        // Simulação de sucesso
        return true;
    }
    
    /**
     * Envia email de recuperação de senha.
     */
    public function sendPasswordReset(string $to, string $code): bool
    {
        $subject = "Recuperação de Senha - CasaSegura";
        $message = "Utilize o seguinte código para redefinir a sua senha: $code";
        
        log_message('info', "EMAIL_RESET para $to: $message");
        
        return true;
    }
}
