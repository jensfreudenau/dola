<?php

namespace App\Models;
class Record extends BaseModel
{
    protected $fillable = ['header', 'records_table', 'sex'];

    public static function boot()
    {
        parent::boot();
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
