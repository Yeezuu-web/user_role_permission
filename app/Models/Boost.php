<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use DateTimeInterface;

class Boost extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'boosts';

    protected $fillable = [
        'requester_name', 
        'company_name', 
        'group', 
        'budget', 
        'program_name', 
        'target_url', 
        'program_name', 
        'boost_start', 
        'boost_end', 
        'detail', 
        'status', 
        'channel_id', 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'boost_start',
        'boost_end',
    ];

    protected $appends = [
        'reference',
    ];

    public function getBoostStartAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setBoostStartAttribute($value)
    {
        $this->attributes['boost_start'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getReferenceAttribute()
    {
        $file = $this->getMedia('reference')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class, 'boost_id', 'channel_id');
    }
}
