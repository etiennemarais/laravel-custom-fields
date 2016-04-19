<?php
namespace Metafields\Models;

use Illuminate\Database\Eloquent\Model;

class Metafields extends Model
{
    protected $table = 'meta_fields';
    public $timestamps = false;

    public $fillable = [
        
    ];

    // This model is to add fields to database and does not contain the values of those custom fields.
}
