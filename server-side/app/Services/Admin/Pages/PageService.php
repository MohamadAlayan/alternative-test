<?php

namespace App\Services\Admin\Pages;

use App\Http\Requests\Admin\Pages\CreatePageRequest;
use App\Http\Requests\Admin\Pages\ListPageRequest;
use App\Http\Response;
use App\Repositories\Page\PageRepository;
use App\Services\Base\BaseService;

class PageService extends BaseService {

    public $repository = PageRepository::class;

    public function __construct(PageRepository $pageRepository) {
        parent::__construct();
        $this->repository = $pageRepository;
    }

    public function listPages(ListPageRequest $listPageRequest) {
        return $this->repository->list($listPageRequest);
    }

    public function allPages(ListPageRequest $allPageRequest) {
        $pages = $this->repository->all($allPageRequest)->get();
        return Response::success(__('messages.pages_list'), $pages);
    }


    public function createPage(CreatePageRequest $createPageRequest) {

        $data = [
            'title' => $createPageRequest->input('title'),
            'slug' => $createPageRequest->input('slug'),
            'status' => $createPageRequest->input('status'),
            'content' => $createPageRequest->input('content'),
            'parent_id' => $createPageRequest->input('parent_id'),
        ];

        $page = $this->repository->create($data);

        return Response::success(__('messages.page_created_successfully'), $page);
    }

    public function deletePage($uuid) {
        $page = $this->repository->getByUuid($uuid);
        $page->delete();

        return Response::success(__('messages.page_deleted_successfully'));
    }

    public function readPage($request) {

        // We can get page by id or page title or slug
        if ($request->has('id')) {
            $page = $this->repository->getById($request->id);
        } else if ($request->has('titles')) {
            $titles = $request->input('titles');
            $potentialPages = collect();
            $page = null;

            foreach ($titles as $index => $title) {
                if ($index == 0) {
                    // Find the root page(s)
                    $potentialPages = $this->repository->where([
                        'title' => $title,
                        'parent_id' => null,
                        'status' => 1
                    ])->get();
                } else {
                    $newPotentialPages = collect();
                    foreach ($potentialPages as $potentialPage) {
                        $childPages = $this->repository->where([
                            'title' => $title,
                            'parent_id' => $potentialPage->id,
                            'status' => 1
                        ])->get();

                        $newPotentialPages = $newPotentialPages->merge($childPages);
                    }
                    $potentialPages = $newPotentialPages;
                }

                if ($potentialPages->isEmpty()) break;
            }


            $page = $potentialPages->first();


            if (!$page) {
                return Response::error(__('messages.page_not_found'));
            }



        } else if ($request->has('slug')) {
            $page = $this->repository->where([
                'slug' => $request->slug,
                'status' => 1
            ])->first();
        } else {
            return Response::error(__('messages.page_not_found'));
        }

        return Response::success(__('messages.page_details'), $page);

    }

    public function updatePage($request) {
        $page = $this->repository->getByUuid($request->uuid);

        if (!$page) {
            return Response::error(__('messages.page_not_found'));
        }

        $data = [
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ];

        $page->update($data);
        $page->refresh();

        return Response::success(__('messages.page_updated_successfully'), $page);
    }

}
