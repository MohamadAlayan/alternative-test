<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pages\CreatePageRequest;
use App\Http\Requests\Admin\Pages\DeletePageRequest;
use App\Http\Requests\Admin\Pages\ListPageRequest;
use App\Http\Requests\Admin\Pages\UpdatePageRequest;
use App\Http\Requests\Admin\Pages\ViewPageRequest;
use App\Services\Admin\Pages\pageService;

class PageController extends Controller
{
    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function listPages(ListPageRequest $request)
    {
        return $this->pageService->listPages($request);
    }

    public function allPages(ListPageRequest $request)
    {
        return $this->pageService->allPages($request);
    }

    public function createPage(CreatePageRequest $request)
    {

        return $this->pageService->createPage($request);
    }

    public function readPage(ViewPageRequest $request)
    {
        return $this->pageService->readPage($request);
    }

    public function updatePage(UpdatePageRequest $request)
    {
        return $this->pageService->updatePage($request);
    }

    public function deletePage(DeletePageRequest $request)
    {
        return $this->pageService->deletePage($request->uuid);
    }
}
