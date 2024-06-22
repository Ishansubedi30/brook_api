<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class CsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = storage_path('data/books.csv');

        if (!File::exists($filePath)) {
            Log::error("CSV file not found: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        if ($header === false) {
            Log::error("Failed to read CSV header.");
            fclose($file);
            return;
        }

        DB::beginTransaction();

        try {
            $chunkSize = 1000; // Number of rows to process at a time
            $rows = [];
            $rowCount = 0;

            while (($row = fgetcsv($file)) !== false) {
                if (count($row) !== count($header)) {
                    Log::warning("Column count mismatch at row $rowCount: ", $row);
                    continue;
                }

                $data = array_combine($header, $row);

                if ($this->isValidRow($data)) {
                    $rows[] = $data;
                    $rowCount++;

                    if ($rowCount % $chunkSize === 0) {
                        DB::table('books')->insert($rows);
                        $rows = [];
                    }
                } else {
                    Log::warning("Invalid data at row $rowCount: ", $data);
                }
            }

            // Insert remaining rows
            if (!empty($rows)) {
                DB::table('books')->insert($rows);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error seeding data: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }

    /**
     * Validate a row of CSV data.
     *
     * @param array $data
     * @return bool
     */
    private function isValidRow(array $data): bool
    {
        return !empty($data['name']) && !empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    }
}
