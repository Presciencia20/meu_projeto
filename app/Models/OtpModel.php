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

    protected $allowedFields = ['telemovel', 'codigo', 'tipo', 'expira_em', 'usado'];

    /**
     * Gera um código OTP de 6 dígitos, invalida os anteriores para o mesmo
     * telemóvel e tipo, e guarda o novo na base de dados.
     */
    public function generateAndSave(string $telemovel, string $tipo): string
    {
        // Invalidar OTPs anteriores do mesmo tipo para este número
        $this->where('telemovel', $telemovel)
             ->where('tipo', $tipo)
             ->where('usado', 0)
             ->set(['usado' => 1])
             ->update();

        $codigo   = (string) random_int(100000, 999999);
        $expiraEm = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $this->insert([
            'telemovel' => $telemovel,
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
    public function verify(string $telemovel, string $codigo, string $tipo): bool
    {
        $record = $this->where('telemovel', $telemovel)
                       ->where('codigo', $codigo)
                       ->where('tipo', $tipo)
                       ->where('usado', 0)
                       ->where('expira_em >', date('Y-m-d H:i:s'))
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
    public function cooldownRemaining(string $telemovel, string $tipo): int
    {
        // Impede reenvio antes de 60 segundos
        $record = $this->where('telemovel', $telemovel)
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
