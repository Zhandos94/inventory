<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Sclasses
 *
 * @property int $id
 * @property string $class_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sclasses whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sclasses extends Model
{
    protected $fillable = [
        'class_name'
    ];
}
