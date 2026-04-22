<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $avatar
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 *
 * @property-read string $avatar
 *
 * @mixin \Eloquent
 */
#[Fillable(['avatar', 'nickname', 'postal_code', 'address', 'building'])]
class Profile extends Model
{
    /**
     * Retrieve an avatar image path of a profile.
     *
     * If avatar is null, return default avatar image path.
     *
     * @return Attribute<string, never>
     */
    protected function avatar(): Attribute
    {
        return Attribute::get(
            fn (?string $value) => $value ?? 'avatars/default-avatar.jpg'
        );
    }

    /**
     * Update a profile avatar.
     */
    public function updateAvatar(?UploadedFile $file): void
    {
        if (! $file) {
            return;
        }

        if ($this->getRawOriginal('avatar')) {
            Storage::disk('public')->delete($this->getRawOriginal('avatar'));
        }

        $this->update(['avatar' => $file->store('avatars', 'public')]);
    }
}
