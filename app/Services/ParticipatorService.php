<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 16:29
 */

namespace App\Services;
use App\Models\Competition;
use App\Models\Participator;
use Illuminate\Support\Facades\Mail;

class ParticipatorService
{
    public function sendCsvFile($participators, Competition $competition)
    {
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
        $column_headers = array('BIB,Code,Event,Team,Telefon,Straße,Stadt,Vorname,Nacname,Value,YOB,discipline,ageclass');
        $filename =  'teilnehmer.csv';
        $file = fopen('php://temp', 'w+');
        fputcsv($file, $column_headers);
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        rewind($file);
        Mail::send('emails.test', [], function($message) use($file, $filename, $competition)
        {
            $message->to($competition->organizer->address->email)
                ->from('info@dortmunder-leichtathletik.de')
                ->subject('Teilnehmerliste '. $competition->header);
            $message->attachData(stream_get_contents($file), $filename);
        });

        fclose($file);
    }



    public function test($a, $b)
    {
        $filename =  'launch_codes.csv';
        $file = fopen('php://temp', 'w+');
        $column_headers = ['Weapon', 'Launch Code'];
        fputcsv($file, $column_headers);
        fputcsv($file, [
            'nuclear_arsenal','swordfish'
        ]);

        rewind($file);

        Mail::send('emails.test', [], function($message) use($file, $filename)
        {
            $message->to('please_not_trump@not-that-secure.gov')
                ->subject('Confidential Data');
            $message->attachData(stream_get_contents($file), $filename);
        });

        fclose($file);
    }
}