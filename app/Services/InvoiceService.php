<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function next(string $prefix, string $dateYmd, string $table, string $column): string
    {
        // prefix contoh: PUR atau SAL
        $date = str_replace('-','',$dateYmd); // YYYYMMDD
        $base = $prefix.'-'.$date.'-';

        return DB::transaction(function () use ($base,$table,$column) {
            // lock tabel via query "for update" style sederhana: ambil max invoice yg sesuai
            $last = DB::table($table)
                ->select($column)
                ->where($column, 'like', $base.'%')
                ->orderBy($column,'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($last) {
                $parts = explode('-', $last->{$column}); // [PUR, YYYYMMDD, 0001]
                $seq = (int)($parts[2] ?? 0);
                $nextNumber = $seq + 1;
            }

            return $base . str_pad((string)$nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
