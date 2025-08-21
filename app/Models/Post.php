<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use NumberFormatter;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        "company_id",
        "job_title",
        "district",
        "city",
        "remotable",
        "can_parttime",
        "min_salary",
        "max_salary",
        "currency_salary",
        "requirement",
        "start_date",
        "end_date",
        "number_applicants",
        "status",
        "is_pinned",
        "slug",
    ];

    protected static function booted()
    {
        static::creating(static function ($object) {
           $object->user_id = auth()->user()->id;
           $object->status = 1;
        });
        static::saved(static function ($object) {
           $city = $object->city;
           $arr = explode(',', $city);
           $arrCity = getAndCachePostCities();
           foreach($arr as $item) {
               if (in_array($item, $arrCity)) {
                   continue;
               }
               $arrCity[] = $item;
           }

           cache()->put(SystemCacheKeyEnum::POST_CITIES, $arrCity);
        });
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }

    public function languages(): MorphToMany
    {
        return $this->morphToMany(
            Language::class,
            'object',
            ObjectLanguage::class,
            'object_id',
            'language_id',
            'id',
            'id',
        );    // Lấy thêm cột type nếu cần
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCurrencySalaryCodeAttribute()
    {
        return PostCurrencySalaryEnum::getKey($this->currency_salary);
    }

    public function getStatusNameAttribute()
    {
        return PostStatusEnum::getKey($this->status);
    }

    public function getLocationAttribute(): ?string
    {
        if(!empty($this->district)){
            return $this->district . ' - ' . $this->city;
        }
        else {
            return $this->city;
        }
    }

    public function getSalaryAttribute(): string
    {
        $value = $this->currency_salary;
        $key = PostCurrencySalaryEnum::getKey($value);
        $locale = PostCurrencySalaryEnum::getLocaleByValue($value);

        $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        $rate = Config::getByKey($key);

        if(!is_null($this->min_salary)) {
            $salary = $this->min_salary * $rate;
            $min_salary = $format->formatCurrency($salary, $key);
        }
        if(!is_null($this->max_salary)) {
            $salary = $this->max_salary * $rate;
            $max_salary = $format->formatCurrency($salary, $key);
        }

        if(!empty($min_salary)) {
            if(!empty($max_salary)) {
                return $min_salary . ' - ' . $max_salary;
            }
            else {
                return __('frontpage.from_salary') . ' ' . $min_salary;
            }
        }
        else {
            if(!empty($max_salary)) {
                return __('frontpage.up_to_salary') . ' ' . $max_salary;
            }
            else {
                return "";
            }
        }
    }
}
