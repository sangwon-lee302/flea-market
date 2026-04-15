<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $image_path
 * @property string|null $nickname
 * @property string|null $postal_code
 * @property string|null $address
 * @property string|null $building
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 *
 * @property-read User $user
 *
 * @mixin \Eloquent
 */
#[Fillable(['image_path', 'nickname', 'postal_code', 'address', 'building'])]
class Profile extends Model
{
    protected function imagePath(): Attribute
    {
        return Attribute::get(
            fn (?string $value) => $value ?? 'avatars/default.jpg'
        );
    }
}
