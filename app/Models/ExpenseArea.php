<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExpenseArea
 *
 * @property int $id
 * @property string $name
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExpenseArea extends Model
{
    use HasFactory;

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_area_id');
    }
}
