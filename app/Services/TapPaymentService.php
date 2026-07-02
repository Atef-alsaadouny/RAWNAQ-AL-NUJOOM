<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TapPaymentService
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $mode;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = Config::get('services.tap.secret_key');
        $this->publicKey = Config::get('services.tap.public_key');
        $this->mode = Config::get('services.tap.mode', 'sandbox');
        $this->baseUrl = $this->mode === 'live'
            ? 'https://api.tap.company/v2'
            : 'https://api.sandbox.tap.company/v2';
    }

    public function createCharge(Appointment $appointment, string $method): array
    {
        $amount = $appointment->total_price;
        $customerName = $appointment->customer_name ?? $appointment->customer?->name ?? 'عميل';
        $customerPhone = $appointment->customer_phone ?? $appointment->customer?->phone ?? '';
        $customerEmail = $appointment->customer?->email ?? 'customer@example.com';

        $callbackParams = ['appointment' => $appointment->id];
        if ($appointment->guest_token) {
            $callbackParams['token'] = $appointment->guest_token;
        }

        $successUrl = route('payment.callback', array_merge($callbackParams, [
            'status' => 'success',
        ]), true);
        $cancelUrl = route('payment.callback', array_merge($callbackParams, [
            'status' => 'cancel',
        ]), true);
        $webhookUrl = route('payment.callback', $callbackParams, true);

        $payload = [
            'amount' => (float) $amount,
            'currency' => config('app.currency', 'KWD'),
            'threeDSecure' => true,
            'save_card' => false,
            'description' => 'حجز رقم ' . $appointment->ticket_number,
            'statement_descriptor' => Config::get('app.name', 'alnjoom'),
            'reference' => [
                'transaction' => (string) $appointment->ticket_number,
                'order' => (string) $appointment->id,
            ],
            'receipt' => [
                'email' => false,
                'sms' => false,
            ],
            'customer' => [
                'first_name' => $customerName,
                'phone' => [
                    'country_code' => '965',
                    'number' => $customerPhone,
                ],
                'email' => $customerEmail,
            ],
            'merchant' => [
                'id' => Config::get('services.tap.merchant_id'),
            ],
            'source' => [
                'id' => $this->mapMethod($method),
            ],
            'redirect' => [
                'url' => $successUrl,
            ],
            'post' => [
                'url' => $webhookUrl,
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Idempotency-Key' => 'booking_' . $appointment->id . '_' . \Illuminate\Support\Str::random(16),
            ])->post($this->baseUrl . '/charges', $payload);

            $body = $response->json();

            if ($response->successful() && isset($body['id'])) {
                return [
                    'success' => true,
                    'charge_id' => $body['id'],
                    'transaction_id' => $body['reference']['transaction'] ?? null,
                    'redirect_url' => $body['transaction']['url'] ?? null,
                    'raw' => $body,
                ];
            }

            Log::error('Tap charge failed', [
                'appointment_id' => $appointment->id,
                'status' => $response->status(),
                'message' => $body['message'] ?? 'No message',
            ]);

            return [
                'success' => false,
                'message' => $body['message'] ?? 'فشل الاتصال ببوابة الدفع',
                'raw' => $body,
            ];
        } catch (\Exception $e) {
            Log::error('Tap charge exception', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء الاتصال ببوابة الدفع',
            ];
        }
    }

    public function retrieveCharge(string $chargeId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/charges/' . $chargeId);

            $body = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $body['status'] ?? 'unknown',
                    'charge_id' => $body['id'],
                    'transaction_id' => $body['reference']['transaction'] ?? null,
                    'amount' => $body['amount'] ?? null,
                    'currency' => $body['currency'] ?? null,
                    'raw' => $body,
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? 'فشل التحقق من حالة الدفع',
            ];
        } catch (\Exception $e) {
            Log::error('Tap retrieve exception', [
                'charge_id' => $chargeId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء التحقق من الدفع',
            ];
        }
    }

    protected function mapMethod(string $method): string
    {
        return match ($method) {
            Payment::METHOD_KNET => 'src_kw.knet',
            Payment::METHOD_APPLE_PAY => 'src_apple_pay',
            Payment::METHOD_GOOGLE_PAY => 'src_google_pay',
            default => 'src_kw.knet',
        };
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function isLive(): bool
    {
        return $this->mode === 'live';
    }}
