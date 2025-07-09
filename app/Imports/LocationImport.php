<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationImport implements ToModel, WithBatchInserts, WithHeadingRow, WithChunkReading
{
    public function model(array $row)
    {
        return new Location([
            'city'       => $row['locality'],
            'state'      => $row['state'],
            'postcode'   => $row['postcode'],
            'locality'   => $row['locality'],
            'address'    => $row['locality'] . ', ' . $row['state'] . ', ' . $row['postcode'],
            'region'     => $row['region'],
            'lat'        => $row['lat'],
            'long'       => $row['long'],
            'sa4'        => $row['sa4'],
            'sa4_name'   => $row['sa4name'],
            'lga_region' => $row['lgaregion'],
            'lga_code'   => $row['lgacode'],
            'country'    => 'Australia',
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
