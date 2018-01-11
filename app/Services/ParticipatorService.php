<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 16:29
 */

namespace App\Services;
use App\Models\Competition;
use Illuminate\Support\Facades\Mail;

class ParticipatorService
{
    public function sendCsvFile($participators, Competition $competition)
    {
        $list = array();
        foreach ($participators as $key => $participator) {
            $list[$key]['BIB']        = 1;
            $list[$key]['Code']       = '';
            $list[$key]['Event']      = $competition->header;
            $list[$key]['Team']       = $participator->Announciator->clubname;
            $list[$key]['telephone']  = $participator->Announciator->telephone;
            $list[$key]['street']     = $participator->Announciator->street;
            $list[$key]['city']       = $participator->Announciator->city;
            $list[$key]['Forename']   = $participator->prename;
            $list[$key]['Name']       = $participator->lastname;
            $list[$key]['Value']      = $participator->best_time;
            $list[$key]['YOB']        = $participator->birthyear;
            $list[$key]['discipline'] = $participator->discipline->dlv;
            $list[$key]['ageclass']   = $participator->ageclass->dlv;
        }
        $columnHeaders = array("BIB","Code","Event","Team","Telefon","Straße","Stadt","Vorname","Nachname","Value","YOB","discipline","ageclass");
        $filename =  'teilnehmer.csv';
        $file = fopen('php://temp', 'w+');
        fputcsv($file, $columnHeaders, ",", '"');
        foreach ($list as $row) {
            fputcsv($file, $row, ",", '"');
        }
        rewind($file);
        Mail::send('emails.registration', ['competition'=>$competition, 'announciator'=> $participators[0]->Announciator], function($message) use($file, $filename, $competition, $participators)
        {
            $message->to($competition->organizer->address->email)
                ->from($participators[0]->Announciator->email)
                ->subject('Teilnehmerliste '. $competition->header);
            $message->attachData(stream_get_contents($file), $filename);

        });

        fclose($file);
    }
}