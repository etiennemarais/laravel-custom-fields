<?php
namespace Metafields\example;

use Illuminate\Database\Eloquent\Model;
use Metafields\Concerns\AddsMetafieldFunctionality;

class Example extends Model
{
    use AddsMetafieldFunctionality;

    protected $table = 'example';
}
