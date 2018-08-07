<form action="/admin/websamples" method="POST" enctype="multipart/form-data">
    
    {{ csrf_field() }}

    Title:<br>
    <input type="text" name="title" id="title">
    <br>
    Description:<br>
    <input type="text" name="description" id="description">
    <br>
    url:<br>
    <input type="text" name="url" id="url">
    <br>
    
    Image:<br>
    <input type="file" name="image">

    <br>
    Status:<br>
    <select name="status" id="status">
        @foreach ($status as $stat)
            <option value="{{ $stat->id }}">{{ $stat->title }}</option>
        @endforeach
    </select>
    <br>

    WebTags:<br>
    @foreach ($webTags as $webTag)
        <input type="checkbox" name="webTags[{{ $webTag->id }}]" value="{{ $webTag->id }}">{{ $webTag->title }}
    @endforeach

    <br>
    <br><br>
    <button type="submit">Submit</button>
</form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif