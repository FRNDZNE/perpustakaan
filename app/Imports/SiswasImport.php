<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('uuid', $row['nisn'])->first();
        return new Siswa([
            'user_id' => $user->id,
            'address' => $row['address'],
            'phone' => preg_replace('/^0/', '62', $row['phone']),
        ]);
    }
}
