@foreach ($categories as $category)
    {!! \App\Services\HelperService::childCategoryRendering($categories,0,$category->parent_category_id) !!}
@endforeach
