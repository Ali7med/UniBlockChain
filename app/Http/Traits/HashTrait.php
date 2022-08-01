<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait HashTrait {
    public function makeHashDocument($single)
    {
        Log::info(json_encode($single));
        $resultHash=$single->id.
        $single->student_id.
        $single->college_id.
        $single->stage_id.
        $single->year_id.
        $single->average.
        $single->avg_1st_rank.
        $single->study_type_id.
        $single->graduation_degree_id.
        $single->number_date_graduation_degree;
        return hash('sha3-256', $resultHash); //Hash::make()
    }
}
