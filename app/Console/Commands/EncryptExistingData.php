<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptExistingData extends Command
{
    protected $signature = 'data:encrypt-existing';
    protected $description = 'Encrypt existing PII data in orders and users tables (RGPD compliance)';

    public function handle(): int
    {
        $this->info('Encrypting existing order data...');

        $orders = DB::table('orders')->get();
        $bar = $this->output->createProgressBar($orders->count());

        foreach ($orders as $order) {
            $update = [];

            // Only encrypt if not already encrypted (check for base64 pattern)
            foreach (['customer_name', 'customer_phone', 'customer_address', 'delivery_instructions'] as $field) {
                $value = $order->$field;
                if ($value !== null && !$this->isEncrypted($value)) {
                    $update[$field] = Crypt::encryptString($value);
                }
            }

            if (!empty($update)) {
                DB::table('orders')->where('id', $order->id)->update($update);
            }

            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        $this->info('Encrypting existing user data...');

        $users = DB::table('users')->get();
        $bar = $this->output->createProgressBar($users->count());

        foreach ($users as $user) {
            $update = [];

            foreach (['phone', 'address'] as $field) {
                $value = $user->$field;
                if ($value !== null && !$this->isEncrypted($value)) {
                    $update[$field] = Crypt::encryptString($value);
                }
            }

            if (!empty($update)) {
                DB::table('users')->where('id', $user->id)->update($update);
            }

            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        $this->info('All existing PII data has been encrypted.');

        return Command::SUCCESS;
    }

    private function isEncrypted(string $value): bool
    {
        // Laravel encrypted values start with "eyJ" (base64 of JSON with iv, value, mac)
        return str_starts_with($value, 'eyJ');
    }
}
