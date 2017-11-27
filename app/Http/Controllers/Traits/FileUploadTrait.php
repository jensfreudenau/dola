<?php

namespace App\Http\Controllers\Traits;

use App\Competition;
use App\Upload;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use jensf\csv\CsvParser;

trait FileUploadTrait
{
    public function parseCSV($request, $bootstrap = false)
    {
        $timeTable1 = '';
        $timeTable2 = '';
        $maxColumns = 8;
        if ($request->hasFile('timetable')) {
            if ($request->file('timetable')->isValid()) {
                $request->file('timetable')->move(public_path() . "/upload/", $request->file('timetable')->getClientOriginalName());
                $uploadFile = public_path() . '/upload/' . $request->file('timetable')->getClientOriginalName();
                if (!ini_get("auto_detect_line_endings")) {
                    ini_set("auto_detect_line_endings", '1');
                }
                $inputCsv = CsvParser::createFromPath($uploadFile);
                $inputCsv->setDelimiter(';');
                $inputCsv->setBootstrap($bootstrap);
                # $inputCsv->setEncodingFrom("utf-8");
                $headers    = $inputCsv->fetchOne();
                $numHeaders = count($headers) - 1;
                if ($numHeaders > $maxColumns) {
                    $dataStack  = $inputCsv->arrayToTable(0, 4);
                    $timeTable1 = $inputCsv->createHtmlTable($dataStack);
                    $inputCsv->setScheduler(false);
                    $timeTable2 = $inputCsv->arrayToTable(5, $numHeaders);
                } else {
                    $dataStack  = $inputCsv->arrayToTable(0, $numHeaders);
                    $timeTable1 = $inputCsv->createHtmlTable($dataStack);
                }
            }
        }
        return ['timetable_1' => $timeTable1, 'timetable_2' => $timeTable2];
    }

    /**
     * File upload trait used in controllers to upload files
     * @param Request $request
     * @param $path
     * @return Request
     */
    public function saveFiles(Request $request, $path)
    {
        $finalRequest = $request;
        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $filename = $request->file($key)->getClientOriginalName();
                Storage::putFileAs($path, $request->file('uploader'), $filename);
                $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
            }
        }
        return $finalRequest;
    }

    public function parsingTable($timetable)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($timetable);
        $dom->preserveWhiteSpace = false;
        $tables                  = $dom->getElementsByTagName('table');
        $rows                    = $tables->item(0)->getElementsByTagName('tr');
        $first                   = '<thead>';
        $tableData               = '<tbody>';
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                $cols = $row->getElementsByTagName('td');
                $first .= '<tr>';
                foreach ($cols as $col) {
                    $first .= '<td>' . trim($col->nodeValue) . '</td>';
                }
                $first .= '</tr>';
            } else {
                $cols = $row->getElementsByTagName('td');
                $tableData .= '<tr>';
                foreach ($cols as $col) {
                    $tableData .= '<td>' . trim($col->nodeValue) . '</td>';
                }
                $tableData .= '</tr>';
            }
        }
        $first             .= '</thead>';
        return '<table>' . $first . $tableData . '</tbody></table>';
    }
    ####################################################################################
    ####################################################################################
    /**
     * aus original Date::
     */
    ####################################################################################
    ####################################################################################
    /**
     * if ($request->has($key . '_max_width') && $request->has($key . '_max_height')) {
     * // Check file width
     * $filename = time() . '-' . $request->file($key)->getClientOriginalName();
     * $file     = $request->file($key);
     * $image    = Image::make($file);
     * if (! file_exists(public_path('uploads/thumb'))) {
     * mkdir(public_path('uploads/thumb'), 0777, true);
     * }
     * Image::make($file)->resize(50, 50)->save(public_path('uploads/thumb') . '/' . $filename);
     * $width  = $image->width();
     * $height = $image->height();
     * if ($width > $request->{$key . '_max_width'} && $height > $request->{$key . '_max_height'}) {
     * $image->resize($request->{$key . '_max_width'}, $request->{$key . '_max_height'});
     * } elseif ($width > $request->{$key . '_max_width'}) {
     * $image->resize($request->{$key . '_max_width'}, null, function ($constraint) {
     * $constraint->aspectRatio();
     * });
     * } elseif ($height > $request->{$key . '_max_width'}) {
     * $image->resize(null, $request->{$key . '_max_height'}, function ($constraint) {
     * $constraint->aspectRatio();
     * });
     * }
     * $image->save(public_path('uploads') . '/' . $filename);
     * $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
     * } else {
     */
}