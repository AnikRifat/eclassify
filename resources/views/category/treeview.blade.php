@foreach ($categories as $category)
    <div class="category">
        <div class="category-header">
            <label>
                <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
                @if(!empty($selected_categories))
                    @if(in_array($category->id,$selected_categories))
                        {{"checked"}}
                        @endif
                    @endif
                >
                {{ $category->name }}
            </label>
            @if (!empty($category->subcategories))
                <i style='font-size:24px' class='fas toggle-button'>&#xf0da;</i>
            @endif
        </div>
        <div class="subcategories" style="display: none;">
            @if (!empty($category->subcategories))
                @include('category.treeview', ['categories' => $category->subcategories,'selected_categories' => $selected_categories ??''])
            @endif
        </div>
    </div>
@endforeach
