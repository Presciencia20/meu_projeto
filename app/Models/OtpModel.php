<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table      = 'codigos_otp';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $updatedField  = '';

    protected $allowedFields = ['identifier', 'codigo', 'tipo', 'expira_em', 'usado'];

    /**
     * Gera um código OTP de 6 dígitos, invalida os anteriores para o mesmo
     * identificador e tipo, e guarda o novo na base de dados.
     */
    public function generateAndSave(string $identifier, string $tipo): string
    {
        // Invalidar OTPs anteriores do mesmo tipo para este identificador
        $this->where('identifier', $identifier)
             ->where('tipo', $tipo)
             ->where('usado', 0)
             ->set(['usado' => 1])
             ->update();

        $codigo   = (env('SMS_FAKE', false) || env('SMS_FAKE', false) === 'true') ? '123456' : (string) random_int(100000, 999999);
        $expiraEm = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Aumentado para 10 minutos para dar margem

        $this->insert([
            'identifier' => $identifier,
            'codigo'    => $codigo,
            'tipo'      => $tipo,
            'expira_em' => $expiraEm,
            'usado'     => 0,
        ]);

        return $codigo;
    }

    /**
     * Verifica se o código é válido (não expirado, não usado, tipo correcto).
     * Se válido, marca como usado e retorna true.
     */
    public function verify(string $identifier, string $codigo, string $tipo): bool
    {
        // Adicionamos uma margem de 10 segundos para compensar dessincronização de relógios
        $now = date('Y-m-d H:i:s', strtotime('-10 seconds'));

        $record = $this->where('identifier', $identifier)
                       ->where('codigo', $codigo)
                       ->where('tipo', $tipo)
                       ->where('usado', 0)
                       ->where('expira_em >', $now)
                       ->first();

        if (! $record) {
            return false;
        }

        $this->update($record['id'], ['usado' => 1]);

        return true;
    }

    /**
     * Verifica se um número já tem um OTP válido recente (evitar spam de SMS).
     * Retorna os segundos restantes ou 0 se pode reenviar.
     */
    public function cooldownRemaining(string $identifier, string $tipo): int
    {
        // Impede reenvio antes de 60 segundos
        $record = $this->where('identifier', $identifier)
                       ->where('tipo', $tipo)
                       ->where('usado', 0)
                       ->where('expira_em >', date('Y-m-d H:i:s'))
                       ->orderBy('id', 'DESC')
                       ->first();

        if (! $record) {
            return 0;
        }

        // Cooldown de 60s baseado no created_at
        $criadoEm = strtotime($record['created_at']);
        $passaram  = time() - $criadoEm;

        return max(0, 60 - $passaram);
    }
}
