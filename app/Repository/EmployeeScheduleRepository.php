<?php

namespace App\Repository;

use App\Models\Schedule;

class EmployeeScheduleRepository extends BaseRepository
{
     /**
     * Configure the Model
     **/
    public function model()
    {
        return Schedule::class;
    }
}