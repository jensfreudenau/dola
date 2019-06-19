<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.02.18
 * Time: 10:26
 */

namespace App\Traits;
use App\Mail\EnrolReceived;
use Illuminate\Support\Facades\Mail;

trait EmailTrait
{
    /**
     * @param $seltecCollection
     * @param $competition
     * @param $participator
     */
    protected function sendEmailWithCsvFile(): void
    {
        $seltecCollection = $this->participatorService->getSeltecCollection();
        $participator     = $this->participatorService->getParticipators();
        $columnHeaders = array('BIB', 'Code', 'Event', 'Team', 'Telefon', 'Straße', 'Stadt', 'Vorname', 'Nachname', 'Value', 'YOB', 'discipline', 'ageclass');
        $filename      = 'teilnehmer.csv';
        $file          = fopen('php://temp', 'w+');
        fputcsv($file, $columnHeaders, ',');
        foreach ($seltecCollection as $row) {
            fputcsv($file, $row, ',');
        }
        rewind($file);
        Mail::send('emails.registration', ['competition' => $this->competition, 'announciator' => $participator[0]->Announciator], function ($message) use ($file, $filename, $participator) {
            $message->to($this->competition->organizer->address->email)
                    ->from($participator[0]->Announciator->email)
                    ->subject('Teilnehmerliste ' . $this->competition->header);
            $message->attachData(stream_get_contents($file), $filename);
        });
        fclose($file);
    }

    /**
     * @param $announciator
     * @param $competition
     */
    protected function sendEmailToAnnounciator(): void
    {
        Mail::send(new EnrolReceived($this->announciator, $this->competition));
    }
}