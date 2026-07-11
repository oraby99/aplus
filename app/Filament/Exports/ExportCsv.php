<?php

namespace App\Filament\Exports;

use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCsv
{
    /**
     * Create a CSV export bulk action for Filament tables.
     *
     * @param string $filename The prefix of the downloaded file name
     * @param array $columns Associative array: ['الاسم في العمود' => 'column_name_or_callback']
     */
    public static function make(string $filename, array $columns): BulkAction
    {
        return BulkAction::make('export_csv')
            ->label('تصدير التقرير (CSV)')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function (Collection $records) use ($filename, $columns): StreamedResponse {
                $response = new StreamedResponse(function () use ($records, $columns) {
                    $handle = fopen('php://output', 'w');
                    
                    // Add UTF-8 BOM to make it open nicely in Microsoft Excel with Arabic encoding
                    fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
                    
                    // Write header row
                    fputcsv($handle, array_keys($columns));
                    
                    // Write data rows
                    foreach ($records as $record) {
                        $row = [];
                        foreach ($columns as $label => $columnNameOrCallback) {
                            if (is_callable($columnNameOrCallback)) {
                                $row[] = $columnNameOrCallback($record);
                            } else {
                                $row[] = $record->{$columnNameOrCallback} ?? '';
                            }
                        }
                        fputcsv($handle, $row);
                    }
                    
                    fclose($handle);
                });
                
                $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '_' . date('Y-m-d_H-i-s') . '.csv"');
                
                return $response;
            })
            ->deselectRecordsAfterCompletion();
    }
}
