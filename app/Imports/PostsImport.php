<?php

namespace App\Imports;

use App\Enums\FileTypeEnum;
use App\Enums\PostStatusEnum;
use App\Models\Company;
use App\Models\File;
use App\Models\Language;
use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostsImport implements ToArray, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $array): void
    {
        try{
            foreach ($array as $each) {
                $companyName = $each['cong_ty'];
                $language = $each['ngon_ngu'];
                $city = $each['dia_diem'];
                $link = $each['link'];

                if(!empty($companyName)) {
                    $companyId = Company::query()->firstOrCreate([
                        'name' => $companyName,
                    ],[
                        'city' => $city,
                        'country' => 'Vietnam'
                    ])->id;
                }
                else {
                    $companyId = null;
                }



                $post = Post::create([
                    'job_title' => $language,
                    'company_id' => $companyId,
                    'city' => $city,
                    'status' => PostStatusEnum::ADMIN_APPROVED,
                ]);

                $languages = explode(',', $language);
                foreach ($languages as $each) {
                    Language::query()->firstOrCreate([
                        'name' => trim($each),
                    ]);
                }

                File::create([
                    'post_id' => $post->id,
                    'link' => $link,
                    'type' => FileTypeEnum::JD,
                ]);
            }
        }
        catch(\Throwable $e){
            dd($each);
        }
    }
}
