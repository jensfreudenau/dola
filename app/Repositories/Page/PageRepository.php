<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 03.01.18
 * Time: 16:33
 */

namespace App\Repositories\Page;

use App\Models\Page;
use App\Repositories\Repository;

class PageRepository extends Repository implements PageRepositoryInterface
{
    protected $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Page::class;
    }
}