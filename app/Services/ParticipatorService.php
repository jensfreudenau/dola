<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 16:29
 */

namespace App\Services;
use App\Models\Participator;
use App\Repositories\Participator\ParticipatorRepositoryInterface;

class ParticipatorService
{
    protected $participatorRepository;

    public function __construct(ParticipatorRepositoryInterface $participatorRepository)
    {
        $this->participatorRepository = $participatorRepository;
    }


    /**
     * @param $request
     * @param $announciatorId
     */
    public function create($request, $announciatorId)
    {
        $participators = [];
        foreach ($request->vorname as $key => $item) {
            $participators[$key]['prename'] = $item;
        }
        foreach ($request->nachname as $key => $item) {
            $participators[$key]['lastname'] = $item;
        }
        foreach ($request->jahrgang as $key => $item) {
            $participators[$key]['birthyear'] = $item;
        }
        foreach ($request->ageclass as $key => $item) {
            $participators[$key]['ageclass_id'] = $item;
        }
        foreach ($request->discipline as $key => $item) {
            $participators[$key]['discipline_id'] = $item;
        }
        foreach ($request->bestzeit as $key => $item) {
            $participators[$key]['best_time'] = $item;
        }

        foreach ($participators as $participator) {
            $participator['announciator_id'] = $announciatorId;
            $this->participatorRepository->create($participator);
        }

    }
}