<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 80px 50px; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #1e293b; 
            line-height: 1.5; 
            font-size: 10.5pt;
        }
        .header { 
            position: fixed; 
            top: -60px; 
            left: 0; 
            right: 0; 
            height: 60px; 
            border-bottom: 2px solid #1a56db; 
            padding-bottom: 10px;
        }
        .footer { 
            position: fixed; 
            bottom: -50px; 
            left: 0; 
            right: 0; 
            height: 40px; 
            font-size: 8pt; 
            text-align: center; 
            color: #64748b; 
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
        .logo-text { font-size: 18pt; font-weight: 900; color: #1a56db; letter-spacing: -1px; }
        .title { 
            font-size: 16pt; 
            font-weight: 800; 
            text-align: center; 
            margin: 30px 0; 
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .section { margin-bottom: 20px; }
        .section-title { 
            font-weight: 800; 
            font-size: 9pt; 
            text-transform: uppercase; 
            color: #1e40af; 
            background: #f1f5f9;
            padding: 6px 12px;
            margin-bottom: 12px;
            border-left: 3px solid #1a56db;
        }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .info-table td { padding: 8px; vertical-align: top; border-bottom: 1px solid #f1f5f9; }
        .label { font-weight: 700; width: 150px; color: #64748b; font-size: 8.5pt; }
        .value { color: #1e293b; font-weight: 500; }
        
        .clause-title { font-weight: 800; font-size: 10pt; margin: 15px 0 8px; color: #1e293b; }
        .clause-text { font-size: 9.5pt; margin-bottom: 10px; text-align: justify; }

        .escrow-box { 
            background: #f8fafc; 
            border: 1px solid #e2e8f0;
            padding: 20px; 
            border-radius: 12px;
            margin-top: 10px;
        }
        .total-amount { font-size: 14pt; font-weight: 900; color: #1a56db; }

        .signatures { margin-top: 50px; width: 100%; }
        .sig-container { display: table; width: 100%; }
        .sig-box { display: table-cell; width: 50%; padding: 10px; text-align: center; }
        .sig-line { border-top: 1px solid #cbd5e1; width: 80%; margin: 0 auto 8px; }
        .sig-label { font-size: 8.5pt; font-weight: 700; color: #64748b; text-transform: uppercase; }

        .authenticity-stamp {
            position: absolute;
            right: 0;
            top: 20px;
            width: 140px;
            height: 140px;
            border: 3px double #16a34a;
            border-radius: 50%;
            display: flex;
            align-content: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            transform: rotate(15deg);
            opacity: 0.8;
            color: #16a34a;
        }
        .stamp-text { font-size: 8pt; font-weight: 900; text-transform: uppercase; }

        .watermark { 
            position: absolute; 
            top: 40%; 
            left: 10%; 
            font-size: 60pt; 
            color: rgba(26, 86, 219, 0.02); 
            transform: rotate(-45deg); 
            z-index: -1000; 
            font-weight: 900;
        }

        .verified-badge {
            background: #f0fdf4;
            color: #16a34a;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: 800;
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="watermark">ARRENDASEGURO VERIFICADO</div>

    <div class="authenticity-stamp">
        <div class="stamp-text">
            <br>DOCUMENTO<br>AUTÊNTICO<br>ARRENDASEGURO<br>VERIFICADO<br>ID: <?= substr($escrow['transaction_id'], 0, 8) ?>
        </div>
    </div>

    <div class="header">
        <div style="float: left;">
            <div class="logo-text">ARRENDASEGURO</div>
            <div style="font-size: 8pt; color: #64748b; font-weight: 600;">PORTAL DE ARRENDAMENTO CERTIFICADO — ANGOLA</div>
        </div>
        <div style="float: right; text-align: right; color: #64748b; font-size: 7.5pt; padding-top: 15px;">
            HOUVE PAGAMENTO SEGURO (ESCROW)<br>
            TRANSAÇÃO: <strong>#<?= $escrow['transaction_id'] ?></strong>
        </div>
    </div>

    <div class="title">Contrato de Arrendamento Habitacional</div>

    <div class="section">
        <div class="section-title">I. Partes Contratantes</div>
        <table class="info-table">
            <tr>
                <td class="label">Senhorio:</td>
                <td class="value">
                    <?= $owner['full_name'] ?> 
                    <span class="verified-badge">BI VERIFICADO: <?= $owner['bi_number'] ?></span>
                </td>
            </tr>
            <tr>
                <td class="label">Arrendatário:</td>
                <td class="value">
                    <?= $tenant['full_name'] ?>
                    <span class="verified-badge">BI VERIFICADO: <?= $tenant['bi_number'] ?></span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">II. Objeto e Localização</div>
        <table class="info-table">
            <tr>
                <td class="label">Imóvel:</td>
                <td class="value"><?= $property['title'] ?></td>
            </tr>
            <tr>
                <td class="label">Tipologia:</td>
                <td class="value"><?= $property['type'] ?? 'Residencial' ?></td>
            </tr>
            <tr>
                <td class="label">Localização:</td>
                <td class="value"><?= $property['neighborhood'] ?>, <?= $property['municipality'] ?>, <?= $property['province'] ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">III. Cláusulas do Contrato</div>
        
        <div class="clause-title">Cláusula 1ª (Duração e Renovação)</div>
        <div class="clause-text">
            O presente contrato tem a duração de 1 (um) ano, com início na presente data, sendo renovável por períodos iguais e sucessivos de 1 ano, salvo se qualquer das partes o denunciar por escrito com a antecedência mínima de 60 dias.
        </div>

        <div class="clause-title">Cláusula 2ª (Renda e Caução em Escrow)</div>
        <div class="clause-text">
            O Arrendatário depositou sob a custódia da CasaSegura o montante total de <strong><?= number_format($escrow['amount'], 0, ',', '.') ?> KZ</strong>, correspondente à primeira renda e caução. Este valor será libertado ao Senhorio apenas após a confirmação presencial do bom estado do imóvel.
        </div>

        <div class="clause-title">Cláusula 3ª (Conservação e Manutenção)</div>
        <div class="clause-text">
            O Senhorio obriga-se a manter o imóvel em condições de habitabilidade, enquanto o Arrendatário obriga-se a zelar pelo mesmo e a realizar as pequenas reparações decorrentes do uso normal.
        </div>

        <div class="clause-title">Cláusula 4ª (Rescisão)</div>
        <div class="clause-text">
            O incumprimento de qualquer uma das cláusulas acima referidas constitui fundamento para a rescisão imediata do contrato por qualquer uma das partes, sem prejuízo das indemnizações legalmente previstas.
        </div>
    </div>

    <div class="section">
        <div class="section-title">IV. Certificação Financeira</div>
        <div class="escrow-box">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <div class="label" style="margin-bottom: 3px;">Renda Mensal</div>
                        <div class="value" style="font-size: 11pt;"><?= number_format($request['monthly_rent'], 0, ',', '.') ?> KZ</div>
                    </td>
                    <td style="width: 50%;">
                        <div class="label" style="margin-bottom: 3px;">Caução de Garantia</div>
                        <div class="value" style="font-size: 11pt;"><?= number_format($request['deposit_amount'], 0, ',', '.') ?> KZ</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="signatures">
        <div class="sig-container">
            <div class="sig-box">
                <div class="sig-line"></div>
                <div class="sig-label">Assinatura do Senhorio (ou Agente)</div>
            </div>
            <div class="sig-box">
                <div class="sig-line"></div>
                <div class="sig-label">Assinatura do Arrendatário</div>
            </div>
        </div>
    </div>

    <div class="footer">
        Documento gerado em <?= $date ?> pela plataforma CasaSegura Angola. <br>
        Este certificado comprova que os fundos foram retidos sob o sistema Anti-Burla e os BI's foram validados pela nossa equipa.
    </div>
</body>
</html>
