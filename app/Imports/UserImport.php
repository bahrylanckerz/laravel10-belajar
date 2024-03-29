<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $i = 1;
        foreach ($collection as $row) {
            if ($i > 1) {
                $user = new User();
                $user->name     = !empty($row[1]) ? $row[1] : '';
                $user->email    = !empty($row[2]) ? $row[2] : '';
                $user->password = !empty($row[3]) ? Hash::make($row[3]) : '';
                $user->save();
            }
            $i++;
        }
    }
}
