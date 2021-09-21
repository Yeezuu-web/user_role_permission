<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $parentColumn = 'parent_id';

    protected $table = "departments";

    protected $fillable = [
        'title', 'parent_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    public function parent()
    {
        return $this->belongsTo(Department::class, $this->parentColumn);
    }

    public function children()
    {
        return $this->hasOne(Department::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
