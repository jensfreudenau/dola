<?php

namespace App\Models;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Record extends Model
{
    use RecordsActivity;
    protected $fillable = ['header', 'records_table', 'sex'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function ($model) {
            $user              = Auth::user();
            $model->updated_by = $user->id;
        });
    }

    public function save(array $options = [])
    {
        $this->replaceTableTag();
        parent::save();
    }

    protected function replaceTableTag()
    {
        $this->records_table = str_replace('<table>', '<table class="table table-hover">', $this->records_table);
    }
}
