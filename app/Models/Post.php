<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use NumberFormatter;


/**
 * @property int $id
 * @property int $user_id
 * @property int|null $company_id
 * @property string $job_title
 * @property string|null $district
 * @property string|null $city
 * @property int|null $remotable
 * @property int|null $can_parttime
 * @property float|null $min_salary
 * @property float|null $max_salary
 * @property int $currency_salary
 * @property string|null $requirement
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int|null $number_applicants
 * @property int $status
 * @property int $is_pinned
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\File|null $file
 * @property-read mixed $currency_salary_code
 * @property-read mixed $is_not_open
 * @property-read string|null $location
 * @property-read mixed $remotable_name
 * @property-read string $salary
 * @property-read mixed $status_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post approved()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post indexHomePage($filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCanParttime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCurrencySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMaxSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMinSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereNumberApplicants($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereRemotable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereRequirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @mixin \Eloquent
 */
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

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];
    protected static function booted()
    {
        static::creating(static function ($object) {
           $object->user_id = auth()->user()->id;
           $object->status = PostStatusEnum::getByRole();
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

    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }

    public function getCurrencySalaryCodeAttribute()
    {
        return PostCurrencySalaryEnum::getKey($this->currency_salary);
    }

    public function getStatusNameAttribute()
    {
        return PostStatusEnum::getKey($this->status);
    }

    public function getRemotableNameAttribute()
    {
        $key = PostRemotableEnum::getKey($this->remotable);
        return Str::title(str_replace('_', ' ', $key));
    }

    public function getLocationAttribute(): ?string
    {
        if(!empty($this->district)){
            return $this->district . ', ' . $this->city;
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

    public function scopeApproved($query)
    {
        return $query->where('status', PostStatusEnum::ADMIN_APPROVED);
    }

    public function getIsNotOpenAttribute()
    {
        if($this->start_date == null || $this->end_date == null){
            return false;
        }
        $today = date('Y-m-d');
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');
        if($today >= $end_date || $today <= $start_date) {
            return true;
        }
        return false;
    }

    public function scopeIndexHomePage($query, $filters)
    {
        return $query
            ->with([
                'languages',
                'company' => function ($q) {
                    return $q->select([
                        'id',
                        'name',
                        'logo'
                    ]);
                }
            ])
            ->approved()
            ->orderByDesc('is_pinned')
            ->orderByDesc('id')
            ->when(isset($filters['cities']), function ($q) use ($filters) {
                return $q->where(function ($q) use ($filters) {
                    foreach ($filters['cities'] as $searchCity) {
                        $q->orWhere('city', 'like', '%'.$searchCity.'%');
                    }
                    $q->orWhereNull('city');
                });
            })
            ->when(isset($filters['min_salary']), function ($q) use ($filters) {
                return $q->where(function ($q) use ($filters) {
                    $q->orWhere('min_salary', '>=', $filters['min_salary']);
                    $q->orWhereNull('min_salary');
                });
            })
            ->when(isset($filters['max_salary']), function ($q) use ($filters) {
                return $q->where(function ($q) use ($filters) {
                    $q->orWhere('max_salary', '<=', $filters['max_salary']);
                    $q->orWhereNull('max_salary');
                });
            })
            ->when(isset($filters['remotable']), function ($q) use ($filters) {
                return $q->where('remotable', $filters['remotable']);
            });
    }
}
