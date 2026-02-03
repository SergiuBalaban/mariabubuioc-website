<?php

namespace App\Models;

use App\Http\Resources\BlogResource;
use App\Policies\BlogPolicy;
use Carbon\Carbon;
use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string|null $cover
 * @property string $title
 * @property string|null $author
 * @property array|string|null $content
 * @property array|string|null $details
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
#[UseResource(BlogResource::class)]
#[UsePolicy(BlogPolicy::class)]
#[UseFactory(BlogFactory::class)]
class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cover',
        'title',
        'author',
        'content',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'details' => 'array',
        ];
    }
}
