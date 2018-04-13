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
    /** @var $ageRange */
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

    /**
     * @param $mnemonic
     * @return mixed
     */
    public function findMnemonic($mnemonic)
    {
        return $this->pageRepository->findBy('mnemonic', $mnemonic);
    }
}