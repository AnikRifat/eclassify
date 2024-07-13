@extends('layouts.main')
@section('title')
    {{__("Create Blogs")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h4 class="mb-0">@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-end">
                @can('blog-create')
                    <a class="btn btn-primary" href="{{ route('blog.create') }}">+ {{__("Add blog")}} </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('blog.show', $category->id ?? 0) }}"
                               data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200,500,2000]" data-search="true" data-search-align="right"
                               data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                               data-trim-on-search="false" data-responsive="true" data-sort-name="id"
                               data-sort-order="asc" data-pagination-successively-size="3" data-query-params="queryParams"
                               data-table="blogs" data-use-row-attr-func="true" data-mobile-responsive="true"
                               data-escape="true"
                               data-show-export="true" data-export-options='{"fileName": "blog-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="title" data-align="center" data-sortable="true">{{ __('Title') }}</th>
                                <th scope="col" data-field="slug" data-align="center" data-sortable="true">{{ __('Slug') }}</th>
                                <th scope="col" data-field="description" data-align="center" data-escape="false">{{ __('Description') }}</th>
                                <th scope="col" data-field="image" data-align="center" data-formatter="imageFormatter">{{ __('Image') }}</th>
                                <th scope="col" data-field="tags" data-align="center">{{ __('Tags') }}</th>
                                <th scope="col" data-field="created_at" data-align="center">{{ __('Date') }}</th>
                                @can(['blog-update', 'blog-delete'])
                                    <th scope="col" data-escape="false" data-field="operate">{{ __('Action') }}</th>
                                @endcan
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
