<?php

namespace App\Models;

use App\Condition;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $image_path
 * @property int $condition
 * @property string $name
 * @property string|null $brand_name
 * @property string $description
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereBrandName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereIsSold($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item search(?string $keyword)
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 *
 * @property-read Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read Collection<int, Like> $likes
 * @property-read int|null $likes_count
 * @property-read Order|null $order
 * @property-read User $user
 * @property-read Collection<int, Comment> $comments
 * @property-read int|null $comments_count
 *
 * @mixin \Eloquent
 */
#[Fillable(['image_path', 'condition', 'name', 'brand_name', 'description', 'price'])]
class Item extends Model
{
    use HasFactory;

    public function casts()
    {
        return [
            'condition' => Condition::class,
        ];
    }

    #[Scope]
    protected function search(Builder $query, ?string $keyword): void
    {
        $query->when($keyword, function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%");
        });
    }

    protected function imagePath(): Attribute
    {
        return Attribute::get(
            fn (?string $value) => $value ?? 'items/default.jpg'
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
