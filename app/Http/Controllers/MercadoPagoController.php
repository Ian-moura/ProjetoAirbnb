<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagamento; // Modelo de Pagamento
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use App\Models\Payment;

class MercadoPagoController extends Controller
{
    public function checkout(Request $request)
    {
        // Configurar a SDK do Mercado Pago
        $amount = 1000; // valor da transação
        $payment = new Payment(1, $request->input('id'));
    
        // instancia a classe pagamento
        $payCreate = $payment->addPayment($amount);
    
        if ($payCreate) {
            // Carregar o access token do arquivo de configuração
            $accesstoken = "TEST-587396347302890-102800-5280f46cdb72ef64844d77270040e853-494406867";
    
            $curl = curl_init();
    
            // Configurar opções do cURL
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "description" => "Payment for product",
                    "external_reference" => $payCreate,
                    "notification_url" => "https://google.com", // URL para notificações
                    "payer" => [
                        "email" => "test_user_123@testuser.com",
                        "identification" => [
                            "type" => "CPF",
                            "number" => "95749019047"
                        ]
                    ],
                    "payment_method_id" => "pix",
                    "transaction_amount" => $amount,
                ]),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'X-Idempotency-Key: ' . uniqid('', true), // Gerando um ID único para evitar duplicações
                    'Authorization: Bearer ' . $accesstoken
                ),
            ));
            
            // Executar a requisição e capturar a resposta
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Obter o código de resposta HTTP
            $curlError = curl_error($curl); // Captura o erro do cURL, se houver
            curl_close($curl);
    
            // Tratar a resposta da API
            if ($httpCode == 200 || $httpCode == 201) { // Checar se a requisição foi bem-sucedida
                $obj = json_decode($response);
    
                if (isset($obj->id)) {
                    $copia_cola = $obj->point_of_interaction->transaction_data->qr_code ?? 'QR code não disponível';
                    $img_qrcode = $obj->point_of_interaction->transaction_data->qr_code_base64 ?? '';
                    $link_externo = $obj->point_of_interaction->transaction_data->ticket_url ?? '#';
                    $transaction_amount = $obj->transaction_amount;
                    $external_reference = $obj->external_reference;
    
                    // Exibir informações do pagamento
                    echo "<h3>R$ {$transaction_amount} (Referência: {$external_reference})</h3> <br />";
                    if ($img_qrcode) {
                        echo "<img src='data:image/png;base64, {$img_qrcode}' width='200' /> <br />";
                    }
                    echo "<textarea>{$copia_cola}</textarea> <br />";
                    echo "<a href='{$link_externo}' target='_blank'>Link para detalhes do pagamento</a>";
    
                    // Botão para marcar pagamento como 'pago'
                    echo "<form method='POST' action='" . route('payment.update', ['id' => $payCreate]) . "'>";
                    echo csrf_field(); // Inclui o token CSRF
                    echo "<button type='submit'>Marcar como Pago</button>";
                    echo "</form>";
                }
            } else {
                // Tratar erros de requisição
                $errorResponse = json_decode($response, true); // Decodifica a resposta JSON em um array
                $errorMessage = isset($errorResponse['message']) ? $errorResponse['message'] : 'Erro desconhecido';
                echo "Erro ao processar o pagamento: {$errorMessage}. Código de erro: {$httpCode}.";
                if ($curlError) {
                    echo " Detalhes do erro cURL: {$curlError}";
                }
            }
        } else {
            echo "Erro ao criar pagamento.";
        }
    }
    
    // Método para atualizar o status do pagamento
    public function updatePaymentStatus($id)
    {
        // Aqui você deve implementar a lógica para atualizar o status na tabela de pagamentos
        $payment = Pagamento::find($id); // Busque o pagamento pelo ID
        if ($payment) {
            $payment->status = 'completed'; // Altera o status para 'pago'
            $payment->save(); // Salva as alterações no banco de dados
    
            // Redireciona para a rota index com uma mensagem de sucesso
            return redirect()->route('index')->with('success', 'Pagamento marcado como pago.');
        }
    
        // Redireciona para a rota index com uma mensagem de erro
        return redirect()->route('index')->with('error', 'Pagamento não encontrado.');
    }
    
    

    public function notification(Request $request)
    {
        // Obtenha os dados da notificação
        $data = $request->all();

        // Verifique se a notificação tem um ID de pagamento
        if (isset($data['id'])) {
            $paymentId = $data['id'];

            // Aqui você pode buscar o pagamento no Mercado Pago para obter detalhes atualizados
            $paymentDetails = $this->getPaymentDetails($paymentId);

            // Atualize seu banco de dados conforme necessário
            if ($paymentDetails) {
                // Supondo que você tenha um modelo de Pagamento
                $pagamento = Pagamento::where('id', $paymentId)->first();
                if ($pagamento) {
                    $pagamento->status = $paymentDetails->status; // Atualiza o status
                    // Adicione quaisquer outros campos que precisar atualizar
                    $pagamento->save();
                }
            }
        }

        // Retorne uma resposta 200 OK para o Mercado Pago
        return response()->json(['status' => 'success']);
    }

    private function getPaymentDetails($paymentId)
    {
        $curl = curl_init();
        $accessToken = "TEST-587396347302890-102800-5280f46cdb72ef64844d77270040e853-494406867"; // Substitua pelo seu token de acesso

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.mercadopago.com/v1/payments/{$paymentId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$accessToken}",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }



}
