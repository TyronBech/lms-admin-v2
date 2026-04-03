<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // A foreign key on model_has_roles.model_id is incompatible with
        // Spatie Permission's polymorphic design (model_id + model_type).
        // Enforcing a hard FK here would break role assignments for any
        // non-usr_users models. No constraint is added.
    }

    public function down(): void
    {
        // Nothing to reverse.
    }
};

