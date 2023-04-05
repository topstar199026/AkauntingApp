<?php

namespace Modules\Projects\Exports;

use App\Abstracts\Export;
use App\Utilities\Date;
use DateInterval;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Modules\Projects\Models\ProjectTaskTimesheet as Model;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TimesheetsExport extends Export implements WithColumnFormatting, WithColumnWidths
{
    public function collection()
    {
        return Model::with('task', 'user')->collectForExport($this->ids, 'started_at', 'project_id');
    }

    public function map($model): array
    {
        $model->task_name = $model->task->name;
        $model->task_billable = $model->task->billable ? trans('general.yes') : trans('general.no');
        $model->task_is_invoiced = $model->task->is_invoiced ? trans('general.yes') : trans('general.no');
        $model->timesheet_user = $model->user->name;
        $model->timesheet_elapsed_time_decimal = $this->convertHoursToDecimal(date_diff(Date::parse($model->started_at), Date::parse($model->ended_at)));
        $model->timesheet_elapsed_time = $model->elapsed_time;
        $model->started_at = ExcelDate::dateTimeToExcel(Date::parse($model->started_at));
        $model->ended_at = ExcelDate::dateTimeToExcel(Date::parse($model->ended_at));

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'task_name',
            'task_billable',
            'task_is_invoiced',
            'timesheet_user',
            'note',
            'started_at',
            'ended_at',
            'timesheet_elapsed_time',
            'timesheet_elapsed_time_decimal',
        ];
    }

    public function headings(): array
    {
        return [
            sprintf('%s %s', trans_choice('projects::general.task', 1), trans('general.name')),
            trans('projects::general.billable'),
            trans('documents.statuses.invoiced'),
            trans_choice('projects::general.member', 1),
            trans_choice('general.notes', 1),
            trans('general.start_date'),
            trans('general.end_date'),
            trans('projects::general.time_hourly'),
            trans('projects::general.time_decimal'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => company_date_format() . ' h:mm',
            'G' => company_date_format() . ' h:mm',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 10,
            'C' => 10,
            'D' => 20,
            'E' => 40,
            'F' => 15,
            'G' => 15,
            'H' => 10,
            'I' => 15,
        ];
    }

    private function convertHoursToDecimal(DateInterval $dateInterval)
    {
        $minutes = ($dateInterval->h * 60) + $dateInterval->i;

        return round($minutes / 60, 2);
    }
}
