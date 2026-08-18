<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mail_address')->nullable()->after('active');
            $table->text('mail_password')->nullable()->after('mail_address');
            $table->string('imap_host')->nullable()->after('mail_password');
            $table->unsignedInteger('imap_port')->nullable()->after('imap_host');
            $table->string('imap_encryption')->nullable()->after('imap_port');
            $table->string('smtp_host')->nullable()->after('imap_encryption');
            $table->unsignedInteger('smtp_port')->nullable()->after('smtp_host');
            $table->string('smtp_encryption')->nullable()->after('smtp_port');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mail_address', 'mail_password', 'imap_host', 'imap_port',
                'imap_encryption', 'smtp_host', 'smtp_port', 'smtp_encryption',
            ]);
        });
    }
};