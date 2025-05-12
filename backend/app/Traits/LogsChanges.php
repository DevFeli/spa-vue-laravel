<?php

namespace App\Traits;

use App\Models\Logs;

trait LogsChanges
{
    public static function bootLogsChanges()
    {
        static::updating(function ($model) {
            $original = $model->getOriginal();
            $changes = $model->getDirty();

            // Se não houve mudanças reais, não registra
            if (empty($changes)) {
                return;
            }

            Logs::create([
                'action'     => 'update',
                'route'      => request()->fullUrl(),
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'old_values' => json_encode($original),
                'new_values' => json_encode($changes),
                'user_id'    => auth()->check() ? auth()->id() : null,
            ]);
        });

        static::created(function ($model) {
            Logs::create([
                'action'     => 'create',
                'route'      => request()->fullUrl(),
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'old_values' => null,
                'new_values' => json_encode($model->getAttributes()),
                'user_id'    => auth()->check() ? auth()->id() : null,
            ]);
        });

        static::deleting(function ($model) {
            Logs::create([
                'action'     => 'delete',
                'route'      => request()->fullUrl(),
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'old_values' => json_encode($model->getOriginal()),
                'new_values' => null,
                'user_id'    => auth()->check() ? auth()->id() : null,
            ]);
        });
    }
}
