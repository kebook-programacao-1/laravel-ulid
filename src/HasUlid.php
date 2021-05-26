<?php
namespace Rorecek\Ulid;

trait HasUlid
{
    protected static function bootHasUlid()
    {
        static::creating(function ($model) {
            $modelUlid = null;

            if(isset($model->ulid)) {
                $modelUlid = $model->ulid;
            }

            if (!$model->$modelUlid) {
                $model->$modelUlid = \Ulid::generate();
            }
        });

        static::saving(function ($model) {
            $modelUlid = null;

            if(isset($model->ulid)) {
                $modelUlid = $model->ulid;
            }

            $originalUlid = $model->getOriginal($modelUlid);
            if ($originalUlid !== $model->$modelUlid) {
                $model->$modelUlid = $originalUlid;
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
