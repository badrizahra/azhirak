<form action="/admin/websamples/{{ $webSample->id }}" method="POST" enctype="multipart/form-data">
    
    {{ csrf_field() }}
    
    {{ method_field('PUT') }}

    Title:<br>
    <input type="text" name="title" id="title" value="{{ $webSample['title'] }}">
    <br>
    Description:<br>
    <input type="text" name="description" id="description" value="{{ $webSample['description'] }}">
    <br>
    url:<br>
    <input type="text" name="url" id="url" value="{{ $webSample['url'] }}">
    <br>
    CurrentImage:<br>
    <img src="{{url( $webSample->image )}}" alt="{{ $webSample->image }}">
    <br>
    NewImage:
    <input type="file" name="image" id="image">
    <br>
    <br>
    Status:<br>
    <select name="status" id="status">
        @foreach ($status as $stat)           
            <option value="{{ $stat->id }}" @if ($webSample->status_id == $stat->id) {{ 'selected' }}  @endif>{{ $stat->title }}</option>
        @endforeach
    </select>
    <br>

    WebTags:<br>
    @foreach ($webTags as $webTag)
        <input type="checkbox" name="webTags[{{ $webTag->id }}]" value="{{ $webTag->id }}"  @if ( in_array( $webTag->id, $webSample->webtags()->get()->toArray() ) )
        {{ 'checked' }}  > 
        @endif>{{ $webTag->title }}
    @endforeach

    <br>
    <br><br>
    <br><br>
    <button type="submit">Submit</button>
</form>

<form action="/admin/websamples/{{ $webSample->id }}" method="POST">
    
    {{ csrf_field() }}
    
    {{ method_field('DELETE') }}

    Delete:<br>
    <button type="submit">Delete</button>

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