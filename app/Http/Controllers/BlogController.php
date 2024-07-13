<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Services\BootstrapTableService;
use App\Services\FileService;
use App\Services\HelperService;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use function compact;
use function view;

class BlogController extends Controller {
    private string $uploadFolder;

    public function __construct() {
        $this->uploadFolder = "blog";
    }

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['blog-list', 'blog-create', 'blog-delete', 'blog-update']);
        return view('blog.index');
    }

    public function create() {
        ResponseService::noPermissionThenRedirect('blog-create');
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('blog-create');
        $request->validate([
            'title'       => 'required',
            'slug'        => 'required',
            'description' => 'nullable',
            'image'       => 'required|mimes:jpg,jpeg,png|max:4096',
            'tags'        => 'nullable|array',
        ]);
        try {
            $data = $request->all();
            $data['slug'] = HelperService::generateUniqueSlug(new Blog(), $request->title);
            if ($request->hasFile('image')) {
                $data['image'] = FileService::compressAndUpload($request->file('image'), $this->uploadFolder);
            }
            Blog::create($data);
            ResponseService::successRedirectResponse("Blog Added Successfully", route('blog.index'));
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th, "BlogController->store");
            ResponseService::errorRedirectResponse();
        }

    }

    public function show(Request $request) {
        ResponseService::noPermissionThenSendJson('blog-list');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'ASC');
        $sql = Blog::orderBy($sort, $order);
        $sql->with('category:id,name');
        if (!empty($request->search)) {
            $sql = $sql->search($request->search);
        }
        $total = $sql->count();
        $sql->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;
        foreach ($result as $key => $row) {
            $operate = '';
            if (Auth::user()->can('blog-update')) {
                $operate .= BootstrapTableService::editButton(route('blog.edit', $row->id));
            }

            if (Auth::user()->can('blog-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('blog.destroy', $row->id));
            }
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-y H:i:s');
            $tempRow['updated_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d-m-y H:i:s');
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function edit($id) {
        ResponseService::noPermissionThenRedirect('blog-update');
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('blog-update');
        try {
            $request->validate([
                'title'       => 'nullable',
                'image'       => 'nullable|mimes:jpg,jpeg,png|max:4096',
                'description' => 'nullable',
                'tags'        => 'nullable|array'
            ]);
            $blog = Blog::find($id);
            $data = $request->all();
            $data['slug'] = HelperService::generateUniqueSlug(new Blog(), $blog->title, $blog->id);
            if ($request->hasFile('image')) {
                $data['image'] = FileService::compressAndReplace($request->file('image'), $this->uploadFolder, $blog->getRawOriginal('image'));
            }
            $blog->update($data);
            ResponseService::successRedirectResponse("Blog Updated Successfully", route('blog.index'));
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th);
            ResponseService::errorRedirectResponse('Something Went Wrong ');
        }
    }

    public function destroy($id) {
        ResponseService::noPermissionThenSendJson('blog-delete');
        try {
            $blog = Blog::find($id);
            FileService::delete($blog->getRawOriginal('image'));
            $blog->delete();
            ResponseService::successResponse('Blog delete successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse('Something Went Wrong ');
        }
    }

}
