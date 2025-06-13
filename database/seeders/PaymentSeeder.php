<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Levy;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $paidLevies = Levy::whereIn('status', ['paid', 'partial'])->get();
        $paymentMethods = ['cash', 'transfer', 'qris'];
        $collectors = ['Budi Santoso', 'Siti Rahayu', 'Ahmad Fauzi', 'Rina Wati'];

        $paymentCount = 0;

        foreach ($paidLevies as $levy) {
            // For paid levies, create full payment
            if ($levy->status === 'paid') {
                $amount = $levy->amount;
            } else {
                // For partial, pay 50-80% of amount
                $amount = (int) ($levy->amount * (rand(50, 80) / 100));
            }

            // Payment date between levy period and due date
            $periodStart = Carbon::createFromFormat('Ym', $levy->period_month)->startOfMonth();
            $paymentDate = $periodStart->copy()->addDays(rand(5, 25));

            // Generate receipt number
            $receiptNo = 'RCPT-' . $paymentDate->format('Ym') . '-' .
                str_pad($paymentCount + 1, 4, '0', STR_PAD_LEFT);

            Payment::firstOrCreate(
                [
                    'levy_id' => $levy->id,
                ],
                [
                    'paid_at' => $paymentDate,
                    'amount' => $amount,
                    'method' => $paymentMethods[array_rand($paymentMethods)],
                    'receipt_no' => $receiptNo,
                    'collector_name' => $collectors[array_rand($collectors)],
                ]
            );

            $paymentCount++;
        }

        $this->command->info("Created {$paymentCount} payment records");
    }
}
