<?php

namespace App\Actions\Contracts;

use App\Models\LegalRequest;

final class GenerateLegalRequestNo
{
    public function handle(): int
    {
        $initRequestNo = 10000001;
        if ($lastRequestNo = LegalRequest::withTrashed()->count()) {
            $incrRequestNo = $initRequestNo + $lastRequestNo;
            if (LegalRequest::withTrashed()->whereRequestNo($incrRequestNo)->count() > 0) {
                return $this->genUniqueRequestNo($incrRequestNo);
            }

            return $incrRequestNo;
        }

        return $initRequestNo;
    }

    /**
     * Generate unique request no if given request no is exists
     */
    protected function genUniqueRequestNo(int $existingRequestNo): int
    {
        $incrRequestNo = $existingRequestNo + 1;
        if (LegalRequest::withTrashed()->whereRequestNo($incrRequestNo)->count() > 0) {
            return $this->genUniqueRequestNo($existingRequestNo);
        }
        return $incrRequestNo;
    }
}
