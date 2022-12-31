@props(['categories', 'selected'])
<select name="category_id" class="primary-input w-full" id="category">
    <option value="">Select Category...</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ $category->id == $selected ? 'selected' : '' }}
        >{{ $category->name }}</option>
    @endforeach
</select>
