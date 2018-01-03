<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 04.12.17
 * Time: 18:18
 */

namespace App\Http\Controllers\Traits;

use App\Models\Ageclass;
use App\Models\Discipline;

trait ProofLADVTrait
{
    public function proofDiscipline($disciplineStr)
    {
        $discipline = Discipline::where('shortname', '=', $disciplineStr)
            ->orWhere('ladv', '=', $disciplineStr)
            ->orWhere('rieping', '=', $disciplineStr)
            ->select('ladv', 'shortname')->first();
        if (!$discipline) {
            $this->disciplineCollectionError[] = $disciplineStr;
            return false;
        } else {
            $this->disciplineCollection[$discipline->ladv] = [$discipline->shortname, $disciplineStr];
            return true;
        }
    }

    protected function proofAgeclasses($class)
    {
        $ageclass = Ageclass::where('shortname', '=', trim($class))
            ->orWhere('ladv', '=', trim($class))
            ->orWhere('rieping', '=', trim($class))
            ->select('ladv', 'shortname')->first();
        if (!$ageclass) {
            $this->ageclassCollectionError[] = $ageclass;
            return false;
        } else {
            $this->ageclassCollection[$ageclass->ladv] = [$ageclass->shortname, $class];
            return true;
        }
    }
}