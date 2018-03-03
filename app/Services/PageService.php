<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.03.18
 * Time: 10:46
 */

namespace App\Services;

use App\Repositories\Ageclass\AgeclassRepositoryInterface;
use App\Repositories\Page\PageRepositoryInterface;
use Illuminate\Support\Carbon;

class PageService
{
    protected $ageRange;
    /**
     * @var AgeclassRepositoryInterface
     */
    protected $ageclassRepository;
    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * PageService constructor.
     * @param AgeclassRepositoryInterface $ageclassRepository
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(AgeclassRepositoryInterface $ageclassRepository, PageRepositoryInterface $pageRepository)
    {
        $this->ageclassRepository = $ageclassRepository;
        $this->pageRepository     = $pageRepository;
    }

    public function loadAgeclasses()
    {
        $classes    = $this->ageclassRepository->whereNotNull('order');
        $ageclasses = [];
        foreach ($classes as $key => $class) {
            $ageclasses[$key]['yearRange'] = $this->createBirthyearRange($class->year_range);
            $ageclasses[$key]['ageRange']  = $class->year_range;
            $ageclasses[$key]['shortname'] = $class->shortname;
            $ageclasses[$key]['name']      = $class->name;
        }
        return $ageclasses;
    }

    /**
     * @param $range
     * @return string
     */
    public function createBirthyearRange($range)
    {
        $ageGroup = '';
        [$rangeStart, $rangeEnd] = explode('-', $range);
        $ageGroup .= Carbon::now()->year - $rangeEnd;
        $ageGroup .= '-';
        $ageGroup .= Carbon::now()->year - $rangeStart;
        return $ageGroup;
    }

    /**
     * @param $mnemonic
     * @return mixed
     */
    public function findMnemonic($mnemonic)
    {
        return $this->pageRepository->findBy('mnemonic', $mnemonic);
    }
}