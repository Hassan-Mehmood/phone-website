@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            {{ __('Edit Sub category') }}
                        </h3>
                    </div>

                    <div class="card-actions">
                        <x-action.close route="{{ route('categories.index') }}" />
                    </div>
                </div>
                <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <x-input label="{{ __('Name') }}" id="sub_category_name" name="sub_category_name"
                            :value="old('sub_category_name', $subcategory->sub_category_name)" required />
                    </div>
                    <div class="card-footer text-end">
                        <x-button type="submit">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @pushonce('page-scripts')
    <script>
        // Slug Generator
        const title = document.querySelector("#name");
        const slug = document.querySelector("#slug");
        title.addEventListener("keyup", function() {
            let preslug = title.value;
            preslug = preslug.replace(/ /g, "-");
            slug.value = preslug.toLowerCase();
        });
    </script>
@endpushonce --}}
