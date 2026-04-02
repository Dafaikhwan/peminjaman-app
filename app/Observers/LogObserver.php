<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class LogObserver
{
    public function created(Model $model)
    {
        catatLog('tambah', 'Menambah data ' . class_basename($model) . ' ID: ' . $model->id);
    }

    public function updated(Model $model)
    {
        catatLog('update', 'Mengubah data ' . class_basename($model) . ' ID: ' . $model->id);
    }

    public function deleted(Model $model)
    {
        catatLog('hapus', 'Menghapus data ' . class_basename($model) . ' ID: ' . $model->id);
    }
}
