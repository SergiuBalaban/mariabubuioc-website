<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use App\Policies\CategoryPolicy;
use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id,
 * @property string $name,
 * @property Carbon $created_at,
 * @property Carbon $updated_at,
 * @property Carbon $deleted_at,
 */
#[UseResource(CategoryResource::class)]
#[UsePolicy(CategoryPolicy::class)]
#[UseFactory(CategoryFactory::class)]
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public static function boot(): void
    {
        self::deleting(function (self $category): void {
            $category->projects()->delete();
        });

        parent::boot();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
