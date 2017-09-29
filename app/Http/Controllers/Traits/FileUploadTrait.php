<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use jensf\csv\CsvParser;

trait FileUploadTrait
{
    public function parseCSV($request)
    {
        $timeTable1='';
        $timeTable2='';
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
               # $inputCsv->setEncodingFrom("utf-8");
                $headers    = $inputCsv->fetchOne();
                $numHeaders = count($headers) - 1;
                if ($numHeaders > $maxColumns) {
                    $timeTable1 = $inputCsv->arrayToTable(0, 4);
                    $inputCsv->setScheduler(false);
                    $timeTable2 = $inputCsv->arrayToTable(5, $numHeaders);
                } else {
                    $timeTable1 = $inputCsv->arrayToTable(0, $numHeaders);
                }
            }
        }
        return ['timetable_1' => $timeTable1, 'timetable_2' => $timeTable2];
    }
    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request)
    {
        if (! file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0777);
            mkdir(public_path('uploads/thumb'), 0777);
        }

        $finalRequest = $request;

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                if ($request->has($key . '_max_width') && $request->has($key . '_max_height')) {
                    // Check file width
                    $filename = time() . '-' . $request->file($key)->getClientOriginalName();
                    $file     = $request->file($key);
                    $image    = Image::make($file);
                    if (! file_exists(public_path('uploads/thumb'))) {
                        mkdir(public_path('uploads/thumb'), 0777, true);
                    }
                    Image::make($file)->resize(50, 50)->save(public_path('uploads/thumb') . '/' . $filename);
                    $width  = $image->width();
                    $height = $image->height();
                    if ($width > $request->{$key . '_max_width'} && $height > $request->{$key . '_max_height'}) {
                        $image->resize($request->{$key . '_max_width'}, $request->{$key . '_max_height'});
                    } elseif ($width > $request->{$key . '_max_width'}) {
                        $image->resize($request->{$key . '_max_width'}, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($height > $request->{$key . '_max_width'}) {
                        $image->resize(null, $request->{$key . '_max_height'}, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $image->save(public_path('uploads') . '/' . $filename);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                } else {
                    $filename = time() . '-' . $request->file($key)->getClientOriginalName();
                    $request->file($key)->move(public_path('uploads'), $filename);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                }
            }
        }

        return $finalRequest;
    }
}