<?php

namespace App\Models;

use App\Http\Resources\ProjectResource;
use App\Policies\ProjectPolicy;
use Carbon\Carbon;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id,
 * @property-read int $category_id,
 * @property-read string $category_name,
 * @property string $title,
 * @property string|null $cover,
 * @property array|string|null $details,
 * @property string|null $price,
 * @property string|null $content,
 * @property Carbon $created_at,
 * @property Carbon $updated_at,
 * @property Carbon $deleted_at,
 */
#[UseResource(ProjectResource::class)]
#[UsePolicy(ProjectPolicy::class)]
#[UseFactory(ProjectFactory::class)]
class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'cover',
        'details',
        'price',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->category->name;
    }
}
