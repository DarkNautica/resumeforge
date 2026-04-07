<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('tailor_credits')->default(0)->after('email');
            $table->string('subscription_status')->nullable()->after('tailor_credits');
            $table->string('stripe_customer_id')->nullable()->after('subscription_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tailor_credits', 'subscription_status', 'stripe_customer_id']);
        });
    }
};
